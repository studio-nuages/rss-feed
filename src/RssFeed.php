<?php
namespace RssFeed;

class RssFeed
{
    protected $dom;
    protected $root;
    protected $channel;

    function __construct($attributes=array()){
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $this->dom = $dom;
        $root = $dom->createElement('rss');
        $root->setAttribute('version', '2.0');
        $dom->appendChild($root);
        $this->root = $root;
        $root->setAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
        $root->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');

        foreach($attributes as $attrKey => $attrValue){
            $root->setAttribute($attrKey, $attrValue);
        }

        $this->channel = $root->appendChild($dom->createElement('channel'));
    }

    public function save($destination){
        return $this->dom->save($destination);
    }

    public function saveXML(){
        return $this->dom->saveXML();
    }

    public function render(){
        header('Content-type:application/rss+xml');
        echo $this->saveXML();
    }

    public function addItem($item){
        $node = $this->dom->createElement('item');
        $this->channel->appendChild($node);

        $params = $item->all();
        foreach($params as $param){
            $element = $this->dom->createElement($param['name']);
            $node->appendChild($element);

            if(isset($param['value']) && !is_null($param['value'])) {
                if(isset($param['cdata']) && $param['cdata'] === true){
                    $cdata = $this->dom->createCDATASection($param['value']);
                    $element->appendChild($cdata);
                } else {
                    $textNode = $this->dom->createTextNode($param['value']);
                    $element->appendChild($textNode);
                }
            }

            if(isset($param['attributes'])){
                foreach($param['attributes'] as $attrKey => $attrValue){
                    if(is_null($attrValue)) continue;
                    $element->setAttribute($attrKey, $attrValue);
                }
            }

            if(isset($param['values']) && is_array($param['values'])) {
                foreach($param['values'] as $key2 => $param2){
                    $child = $this->dom->createElement($key2);
                    $element->appendChild($child);

                    if(isset($param2['value']) && !is_null($param2['value'])) {
                        if(isset($param2['cdata']) && $param2['cdata'] === true){
                            $cdata = $this->dom->createCDATASection($param2['value']);
                            $child->appendChild($cdata);
                        } else {
                            $textNode = $this->dom->createTextNode($param2['value']);
                            $child->appendChild($textNode);
                        }
                    }

                    if(isset($param2['attributes'])){
                        foreach($param2['attributes'] as $attrKey => $attrValue){
                            if(is_null($attrValue)) continue;
                            $child->setAttribute($attrKey, $attrValue);
                        }
                    }
                }
            }
        }
    }

    public function title($value){
        $elem = $this->dom->createElement('title', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function description($value){
        $elem = $this->dom->createElement('description');
        $this->channel->appendChild($elem);
        $cdata = $this->dom->createCDATASection($value);
        $elem->appendChild($cdata);
        return $this;
    }

    public function link($value){
        $elem = $this->dom->createElement('link', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function atomLink($href, $rel='self', $type='application/rss+xml'){
        $elem = $this->dom->createElement('atom:link');
        $elem->setAttribute('href', $href);
        if($rel) $elem->setAttribute('rel', $rel);
        if($type) $elem->setAttribute('type', $type);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function pubDate($value){
        $date = new \DateTime($value);
        $elem = $this->dom->createElement('pubDate', $date->format(\DateTime::RFC2822));
        $this->channel->appendChild($elem);
        return $this;
    }

    public function lastBuildDate($value){
        $date = new \DateTime($value);
        $elem = $this->dom->createElement('lastBuildDate', $date->format(\DateTime::RFC2822));
        $this->channel->appendChild($elem);
        return $this;
    }

    public function generator($value){
        $elem = $this->dom->createElement('generator', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function language($value){
        $elem = $this->dom->createElement('language', $value);
        $this->channel->appendChild($elem);
    }

    public function webMaster($value){
        $elem = $this->dom->createElement('webMaster', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function managingEditor($value){
        $elem = $this->dom->createElement('managingEditor', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function copyright($value){
        $elem = $this->dom->createElement('copyright', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function category($value, $domain=null){
        $elem = $this->dom->createElement('category', $value);
        if($domain) $elem->setAttribute('domain', $domain);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function image($params){
        $elem = $this->dom->createElement('image');
        foreach($params as $key => $value){
            $elem->appendChild($this->dom->createElement($key, $value));
        }
        $this->channel->appendChild($elem);
        return $this;
    }

    public function ttl($value){
        $elem = $this->dom->createElement('ttl', $value);
        $this->channel->appendChild($elem);
        return $this;
    }

    public function addCustomElement($name, $value, $attributes=array(), $cdata=false){
        $elem = $this->dom->createElement($name);
        foreach($attributes as $key => $value){
            $elem->setAttribute($key, $value);
        }

        if($cdata){
            $cdata = $this->dom->createCDATASection($value);
            $elem->appendChild($cdata);
        } else {
            $elem->nodeValue = $value;
        }

        $this->channel->appendChild($elem);
        return $this;
    }
}
