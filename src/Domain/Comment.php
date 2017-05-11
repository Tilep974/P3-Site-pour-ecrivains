<?php

namespace Livre\Domain;

class Comment 
{
    private $id;

    private $author;

    private $content;

    private $article;
	
	private $par_id;
	
	private $level;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }
	
	public function getParentId() {
		return $this->par_id;
	}
	
	public function setParentId($par_id) {
		$this->par_id = $par_id;
		return $this;
	}
	
	public function getLevel() {
		return $this->level;
	}
	
	public function setLevel($level) {
		$this->level = $level;
		return $this;
	}
}