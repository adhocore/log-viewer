<?php


/**
 * Test the endpoints are up.
 */
class FunctionalTest extends TestCase
{
    public function testRootUrl()
    {
        $this->get('/');

        $this->assertSame(302, $this->response->getStatusCode(), 'Should redirect');
        $this->assertSame('http://localhost/log', $this->response->getTargetUrl());
    }

    public function testLandingUrl()
    {
        $this->get('/log');

        $content = $this->response->getContent();

        $this->assertSame(200, $this->response->getStatusCode(), 'Should be OK');
        $this->assertContains('Log Viewer', $content);
    }

    public function testFetchLogUrl()
    {
        $file   = realpath(__DIR__ . '/stub/log.log');
        $expect = file($file, FILE_IGNORE_NEW_LINES);

        putenv('LOG_PATH=tests/stub');

        $this->get('/log/file?offset=1&logpath=log.log');

        $this->assertSame(200, $this->response->getStatusCode(), 'Relative path should be OK');
        $this->seeJson(['offset' => 1,  'body' => $expect[0]]);
        $this->seeJson(['offset' => 10, 'body' => $expect[9]]);
        $this->dontSeeJson(['offset' => 11, 'body' => $expect[10]]);

        putenv('LOG_PATH=' . dirname($file));

        $this->get(sprintf('/log/file?offset=11&logpath=%s', $file));

        $this->assertSame(200, $this->response->getStatusCode(), 'Full path should be OK');
        $this->seeJson(['offset' => 11, 'body' => $expect[10]]);
        $this->dontSeeJson(['offset' => 10, 'body' => $expect[9]]);

        $this->get('/log/file?offset=-1&logpath=log.log');

        $this->assertSame(200, $this->response->getStatusCode(), 'Last chunk should be OK');
    }

    public function testFetchLogWithInvalidParams()
    {
        $this->get('/log/random');

        $this->assertSame(400, $this->response->getStatusCode(), 'Should NOT be OK');
        $this->seeJson(['error' => 'Type "random" not yet implemented']);

        $this->get('/log/file?logpath=random');

        $this->assertSame(400, $this->response->getStatusCode(), 'Should NOT be OK');
        $this->seeJson(['error' => 'The log path is invalid']);

        putenv('LOG_PATH=tests/stub');

        $this->get('/log/file?logpath=' . __FILE__);

        $this->assertSame(403, $this->response->getStatusCode(), 'Should NOT be OK');
        $this->seeJson(['error' => 'The log path is not in allowed path']);
    }
}
