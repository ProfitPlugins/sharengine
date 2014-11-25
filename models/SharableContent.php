<?php


class SharableContent
{
    public $contentTable;
    public $tagsTable;
    public $linkTable;

    public $promotionTable;
    public $servicesTable;

    public $type;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;


        $this->contentTable = SE_SOCIAL_CONTENT;
        $this->tagsTable = SE_TAGS;
        $this->linkTable =  SE_TWEETS_TAGS;

        $this->promotionTable = SE_PROMOS;
        $this->servicesTable = SE_SERVICES;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        if($this->type)
            return $this->type;
        else
            return "twitter";
    }
    public function getPosts($tags = array())
    {
        $type = $this->getType();


        $tagsString="";
        foreach($tags as $tagID)
        {
            $tagsString.="'$tagID',";
        }

        $tagsString = substr($tagsString,0, strlen($tagsString)-1);

        if(!empty($tags) and count($tags)>1)
        {
            $query =" SELECT DISTINCT ta.id, ta.content,ta.link, ta.image FROM `{$this->wpdb->prefix}{$this->contentTable}` ta
            JOIN `{$this->wpdb->prefix}{$this->linkTable}` li ON li.tweet_id = ta.id
            JOIN `{$this->wpdb->prefix}{$this->tagsTable}` tags ON tags.id = li.tag_id
           WHERE tags.id IN ({$tagsString}) AND ta.type = '{$type}'";
        }
        else if(is_array($tags) && count($tags) == 1)
        {
            $query =" SELECT DISTINCT ta.id, ta.content,ta.link, ta.image
            FROM `{$this->wpdb->prefix}{$this->contentTable}` ta
            JOIN `{$this->wpdb->prefix}{$this->linkTable}` li ON li.tweet_id = ta.id
            JOIN `{$this->wpdb->prefix}{$this->tagsTable}` tags ON tags.id = li.tag_id
           WHERE tags.id = {$tags[0]} AND ta.type='{$type}'";
        }
        else
        {
            $query = "SELECT ta.id, ta.content, ta.link, ta.image FROM  `{$this->wpdb->prefix}{$this->contentTable}` ta WHERE type='{$type}';";
           /* $query =" SELECT ta.id, ta.content,ta.link
            FROM `{$this->wpdb->prefix}se_tweets` ta
            JOIN `{$this->wpdb->prefix}se_tweetstags` li ON li.tweet_id = ta.id
            JOIN `{$this->wpdb->prefix}se_tags` ON ta.id = li.tag_id
            ";*/
        }



        $data = $this->wpdb->get_results($query, ARRAY_A);

        return $data;
        //print_r($data);
    }

    public function tagNameToID($name)
    {

        $ID = $this->wpdb->get_var("SELECT id FROM `{$this->wpdb->prefix}{$this->tagsTable}` WHERE tag='{$name}'");

        return $ID;
    }

    public function getTags($id)
    {
        // get all tags
        if($id =='')
        {
            $query = "SELECT * FROM `{$this->wpdb->prefix}{$this->tagsTable}`";
            $data = $this->wpdb->get_results($query, ARRAY_A);
        }
        else
        {
            $tagsString="";
            foreach($id as $tagID)
            {
                $tagsString.="'$tagID',";
            }

            $tagsString = substr($tagsString,0, strlen($tagsString)-1);

           /* $query = "SELECT ta.id, ta.tag
                FROM `{$this->wpdb->prefix}se_tags` ta
                JOIN `{$this->wpdb->prefix}se_tweetstags` li ON li.tweet_id = ta.id
                JOIN `{$this->wpdb->prefix}se_tweets` tw ON li.tweet_id = li.tag_id
                WHERE tw.id = {$id};
            ";*/
            $query = "SELECT ta.id, ta.tag
                FROM `{$this->wpdb->prefix}{$this->tagsTable}` ta
                JOIN `{$this->wpdb->prefix}{$this->linkTable}` li ON li.tag_id = ta.id

                WHERE li.tweet_id = {$id};
            ";

           // var_dump($query);
            $data = $this->wpdb->get_results($query, ARRAY_A);

           // var_dump($data);
        }



        return $data;
    }


    public function insertTweet($content, $link, $image = '')
    {
        $table = "{$this->wpdb->prefix}{$this->contentTable}";
        $data['content'] = $content;
        $data['link'] = $link;
        $data['image'] = $image;
        $data['type'] = $this->getType();

        $this->wpdb->insert($table, $data);

        return $this->wpdb->insert_id;
    }
    public function updateTweet($id, $content, $link, $image ='')
    {
        $table = "{$this->wpdb->prefix}{$this->contentTable}";
        $data['content'] = $content;
        $data['link'] = $link;

        $data['image'] = $image;

        $where['id'] = $id;
        $this->wpdb->update($table, $data, $where);

        return true;
    }

    public function deleteLinks($tweet_id)
    {
        $table = "{$this->wpdb->prefix}{$this->linkTable}";

        $where['tweet_id'] = $tweet_id;

        $this->wpdb->delete($table, $where);
    }

    public function tagExists($tag)
    {
        $table = "{$this->wpdb->prefix}{$this->tagsTable}";

        $tags_count = $this->wpdb->get_results("SELECT * FROM {$table} WHERE tag='{$tag}'", ARRAY_A);



        if(count($tags_count) == 0)
            return 0;

        return $tags_count[0]['id'];
    }
    public function tagExistsID($ID)
    {
        $table = "{$this->wpdb->prefix}{$this->tagsTable}";

        $tags_count = $this->wpdb->get_results("SELECT * FROM {$table} WHERE id='{$ID}'");

        if(count($tags_count) == 0)
            return 0;

        return $tags_count[0]->id;
    }

    public function insertTag($tag)
    {
        $table = "{$this->wpdb->prefix}{$this->tagsTable}";
        $data['tag'] = $tag;

        if(!$this->tagExists($tag))
        {
            $this->wpdb->insert($table, $data);
            return $this->wpdb->insert_id;
        }

        return $this->tagExists($tag);

    }

    public function link($tweet_id, $tag_id)
    {
        $table = "{$this->wpdb->prefix}{$this->linkTable}";

        $data['tweet_id'] = $tweet_id;
        $data['tag_id']= $tag_id;

        $this->wpdb->insert($table, $data);
    }

    public function insertPromotion($promotion_name, $promotion_tags)
    {
        $success = 1;
        $table = $this->wpdb->prefix.$this->promotionTable;
        $data['name'] = $promotion_name;


        $this->wpdb->insert($table, $data);

        $promotion_id = $this->wpdb->insert_id;

        if(!$promotion_id)
            $success=0;
        $tags = explode(',', $promotion_tags);
        foreach($tags as $tag)
        {
            $tag_id = $this->insertTag($tag);

            $this->link($promotion_id, $tag_id);
        }
        return $success;
    }
    public function deletePromotion($promotion_id)
    {
        $table = $this->wpdb->prefix.$this->promotionTable;

        $where['id'] = $promotion_id;

        return $this->wpdb->delete($table, $where);
    }
    public function getPromotion($id)
    {
        $table = $this->wpdb->prefix.$this->promotionTable;

        $row = $this->wpdb->get_row("SELECT * FROM {$table} WHERE id='{$id}'", ARRAY_A);

        return $row;
    }

    public function getPromotions($tags = array())
    {
        //$type = $this->getType();
        $tagsString="";
        foreach($tags as $tagID)
        {
            $tagsString.="'$tagID',";
        }

        $tagsString = substr($tagsString,0, strlen($tagsString)-1);

        if(!empty($tags) and count($tags)>1)
        {
            $query =" SELECT DISTINCT ta.id, ta.name FROM `{$this->wpdb->prefix}{$this->promotionTable}` ta
            JOIN `{$this->wpdb->prefix}{$this->linkTable}` li ON li.tweet_id = ta.id
            JOIN `{$this->wpdb->prefix}{$this->tagsTable}` tags ON tags.id = li.tag_id
           WHERE tags.id IN ({$tagsString})";
        }
        else if(is_array($tags) && count($tags) == 1)
        {
            $query =" SELECT DISTINCT ta.id, ta.name
            FROM `{$this->wpdb->prefix}{$this->promotionTable}` ta
            JOIN `{$this->wpdb->prefix}{$this->linkTable}` li ON li.tweet_id = ta.id
            JOIN `{$this->wpdb->prefix}{$this->tagsTable}` tags ON tags.id = li.tag_id
           WHERE tags.id = {$tags[0]}";
        }
        else
        {
            $query = "SELECT id, name FROM `{$this->wpdb->prefix}{$this->promotionTable}`;";
            /* $query =" SELECT ta.id, ta.content,ta.link
             FROM `{$this->wpdb->prefix}se_tweets` ta
             JOIN `{$this->wpdb->prefix}se_tweetstags` li ON li.tweet_id = ta.id
             JOIN `{$this->wpdb->prefix}se_tags` ON ta.id = li.tag_id
             ";*/
        }



        $data = $this->wpdb->get_results($query, ARRAY_A);

        return $data;
        //print_r($data);
    }


    //

    public function insertService($promo_id, array $fields, $type,  $enabled=1)
    {
        $table = $this->wpdb->prefix.$this->servicesTable;

        $data['content'] = serialize($fields);
        $data['promotion_id'] = $promo_id;
        $data['enabled'] = $enabled;
        $data['type'] = $type;

        $this->wpdb->insert($table, $data);
    }
    public function updateService($service_id, $fields)
    {
        $table = $this->wpdb->prefix.$this->servicesTable;
        $where['id']=$service_id;

        $this->wpdb->update($table, $fields, $where);
    }
    public function getServices($promo_id)
    {
        $table = $this->wpdb->prefix.$this->servicesTable;

        $query = "SELECT * FROM {$table} WHERE promotion_id='{$promo_id}'";

        $results = $this->wpdb->get_results($query, ARRAY_A);

        foreach($results as $k=>$v)
        {
            $new_results[$v['type']]=$v;
        }
        return $new_results;
    }

}