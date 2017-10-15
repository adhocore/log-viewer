@extends('layout')

@section('content')
<div id="app" class="container app">
  <div class="top">
    <form method="post" v-on:submit.prevent="changePath">
      <input type="input" name="logpath" v-model="newPath" class="text" placeholder="path/to/file" />
      <input type="submit" name="view" value="View" class="btn" />
    </form>
  </div>
  <div class="feedback" v-if="errors">
    <p class="error">[[ errors ]]</p>
  </div>
  <div class="content">
    <div v-for="item in logItems" class="row">
      <div class="col offset">[[ item.offset ]]</div>
      <div class="col body">[[ item.body ]]</div>
    </div>
  </div>
  <div class="nav">
    <ul :class="'inline' + (errors ? ' disabled' : '')">
      <li v-on:click="begin">
        <a href="#">|&lt;</a>
      </li>
      <li v-on:click="prev">
        <a href="#">&lt;</a>
      </li>
      <li v-on:click="next">
        <a href="#">&gt;</a></li>
      <li v-on:click="end">
        <a href="#">&gt;|</a>
      </li>
    </ul>
    <div class="clear"></div>
  </div>
</div>
@endsection
