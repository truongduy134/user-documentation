<?hh // strict

abstract class WebPageController extends WebController {
  protected abstract function getTitle(): Awaitable<string>;
  protected abstract function getBody(): Awaitable<\XHPRoot>;

  final public async function respond(): Awaitable<void> {
    list($title, $body) = await \HH\Asio\va2(
      $this->getTitle(),
      $this->getBody(),
    );

    $xhp =
      <x:doctype>
        <html>
          <head>
            <title>{$title}</title>
            <link rel="shortcut icon" href="/favicon.png" />
          </head>
          <body>{$body}</body>
        </html>
      </x:doctype>;
    $string = await $xhp->asyncToString();
    print($string);
  }

}
