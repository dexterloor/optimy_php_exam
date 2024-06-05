<?php

namespace App\Utility;

class Utils
{
    public static function displayNewsItem($news)
    {
        $return = "############ NEWS ".$news->getTitle()." ############\n";
        $return .= $news->getBody()."\n";

        return $return;
    }

    public static function displayCommentItem($comment)
    {
        return "Comment " . $comment->getId() . " : " . $comment->getBody() . "\n";
    }
}