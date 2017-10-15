/**
 * @package logviewer
 * @author  Jitendra Adhikari <jiten.adhikary at gmail dot com>
 */
new Vue({
  el: '#app',

  delimiters: ['[[', ']]'],

  data: {
    /** @type {string} The currently viewed log path */
    logPath: null,

    /** @type {string} The changed state of logPath from the input */
    newPath: null,

    /** @type {Number} The currently viewed log offset which can be relative (eg: -1 for last) */
    offset: 1,

    /** @type {Number} The absolute log offset */
    newOffset: 1,

    /** @type {Number} The max number of log items per view */
    batchSize: LOG_SIZE,

    /** @type {string} The backend endpoint to fetch log */
    logUrl: LOG_URL,

    /** @type {string} Fetch errors if any */
    errors: null,

    /** @type {Array} Log items where each item is an object with offset and body */
    logItems: [],

    /** @type {Boolean} Tells if next page can be loaded */
    hasNext: true,

    /** @type {Boolean} Tells if there is a request ongoing */
    fetching: false,
  },

  // When logPath or offset changes, fetch the log accordingly.
  watch: {
    logPath: 'fetchLog',

    offset() {
      this.errors || this.fetchLog();
    },
  },

  methods: {
    /**
     * Fetch log for current offset and logPath.
     */
    fetchLog () {
      if (!this.logPath || !this.offset || this.fetching) return;

      const params = `?offset=${this.offset}&logpath=${this.logPath}`;

      /**
       * The request failure handler. Updates errors if any.
       *
       * @param  {Response|Error|string} response
       */
      const onFailure = (response) => {
        if (response instanceof Response) {
          response.json().then(json => {
            this.logItems = [];
            this.errors   = String(json.error || 'Something went wrong!');
          });
        } else {
          this.logItems = [];
          this.errors   = String(response instanceof Error ? response.message : response);
        }
      };

      this.fetching = true;

      fetch(this.logUrl + params, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      }).then(response => {
        this.fetching = false;

        if (response.status < 200 || response.status > 399) {
          onFailure(response);
        } else {
          response.json().then(json => {
            this.errors    = null;
            this.logItems  = json.data;
            this.newOffset = json.offset;
            this.hasNext   = json.next;
          });
        }
      }).catch(onFailure);
    },

    /**
     * Update log path when the input changes.
     */
    changePath() {
      if (this.logPath !== this.newPath) {
        this.logPath = this.newPath;
        this.offset  = 1; // Load new log from start.
      }
    },

    /**
     * Go to the beginning of log file. Sets offset to 1.
     */
    begin() {
      this.offset = this.newOffset = 1;
    },

    /**
     * Go to prev page. Decrements offset by {batchSize}.
     */
    prev() {
      if (this.newOffset - this.batchSize > 0) {
        this.offset = this.newOffset - this.batchSize;
      }
    },

    /**
     * Go to next page. Increments offset by {batchSize}.
     */
    next() {
      if (this.hasNext) {
        this.offset = this.newOffset + this.batchSize;
      }
    },

    /**
     * Go to the end of the log file.
     */
    end() {
      this.offset = -1;
    }
  }
});
