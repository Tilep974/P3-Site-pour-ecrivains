<?php

namespace Livre\DAO;

use Livre\Domain\Article;

class ArticleDAO extends DAO
{
	public function findAll() {
		$sql = "select * from t_article order by art_id desc";
		$result = $this->getDb()->fetchAll($sql);
		
		$articles = array();
		foreach ($result as $row) {
			$articleId = $row['art_id'];
			$articles[$articleId] = $this->buildDomainObject($row);
		}
		return $articles;
	}
	
	public function find($id) {
		$sql = "select * from t_article where art_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));
		
		if ($row)
			return $this->buildDomainObject($row);
		else
			throw new \Exception("No article matching id " . $id);
	}
	
	public function save(Article $article) {
		$articleData=array(
			'art_title' => $article->getTitle(),
			'art_content' => $article->getContent(),
		);
		
		if ($article->getId()) {
			$this->getDb()->update('t_article', $articleData, array('art_id' => $article->getId()));
		} else {
			$this->getDb()->insert('t_article', $articleData);
			$id = $this->getDb()->lastInsertId();
			$article->setId($id);
		}
	}
	
	public function delete($id) {
		$this->getDb()->delete('t_article', array('art_id' => $id));
	}
			
	
	protected function buildDomainObject(array $row) {
        $article = new Article();
        $article->setId($row['art_id']);
        $article->setTitle($row['art_title']);
        $article->setContent($row['art_content']);
        return $article;
    }
}