# RssFeed
Simple RSS 2.0 feed generator for PHP

```php
<?php
use RssFeed\RssFeed;
use RssFeed\RssItem;

$rss = new RssFeed();
$rss->title('Site Title')
    ->description('Site Description')
    ->link('http://example.com/')
    ->atomLink('http://example.com/rss.xml');

$item = new RssItem();
$item->title('Post 1')
    ->description('Your description here')
    ->link('http://example.com/1&test=123')
    ->guid('http://example.com/1')
    ->pubDate('2015-01-02 12:23:34');

$rss->addItem($item);
$rss->render();
```
