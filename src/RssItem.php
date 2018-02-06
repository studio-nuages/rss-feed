<?php
namespace RssFeed;

class RssItem
{
    protected $params = array();

    public function all(){
        return $this->params;
    }

    public function title($value){
        $this->params[] = [
            'name' => 'title',
            'value' => $value
        ];
        return $this;
    }

    public function link($value){
        $this->params[] = [
            'name' => 'link',
            'value' => $value
        ];
        return $this;
    }

    public function guid($value, $isPermaLink=true){
        $this->params[] = [
            'name' => 'guid',
            'value' => $value,
            'attributes' => ['isPermaLink' => ($isPermaLink) ? 'true' : 'false']
        ];
        return $this;
    }

    public function description($value){
        $this->params[] = [
            'name' => 'description',
            'value' => $value,
            'cdata' => true
        ];
        return $this;
    }

    public function pubDate($value){
        $date = new \DateTime($value);
        $this->params[] = [
            'name' => 'pubDate',
            'value' => $date->format(\DateTime::RFC2822)
        ];
        return $this;
    }

    public function source($value, $url){
        $this->params[] = [
            'name' => 'source',
            'value' => $value,
            'attributes' => ['url' => $url]
        ];
        return $this;
    }

    public function enclosure($url, $length, $type){
        $this->params[] = [
            'name' => 'enclosure',
            'attributes' => [
                'url' => $url,
                'length' => $length,
                'type' => $type
            ]
        ];
        return $this;
    }

    public function comments($value){
        $this->params[] = [
            'name' => 'comments',
            'value' => $value
        ];
        return $this;
    }

    public function category($value, $domain=null){
        $this->params[] = [
            'name' => 'category',
            'value' => $value,
            'attributes' => ['domain' => $domain],
            'cdata' => true
        ];
        return $this;
    }

    public function author($value){
        $this->params[] = [
            'name' => 'author',
            'value' => $value,
            'cdata' => true
        ];
        return $this;
    }

    public function dcCreator($value){
        $this->params[] = [
            'name' => 'dc:creator',
            'value' => $value,
            'cdata' => true
        ];
        return $this;
    }

    public function addCustomElement($name, $value, $attributes=array(), $cdata=false){
        $this->params[] = [
            'name' => $name,
            'value' => $value,
            'attributes' => $attributes,
            'cdata' => $cdata
        ];
        return $this;
    }
}
