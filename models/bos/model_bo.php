<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ModelBo extends ActorBo {
    private $actor_name;
    private $actor_bo;
    private $actor_attribute_bo;
    private $actor_attributes;
    private $do;
    private $dao;

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function __construct(
      string $actor_name_plural, # But because of the hack which can be founbd lower, can be singular as well. [artidas]
      ActorBo $actor_bo,
      ActorAttributeBo $actor_attribute_bo,
      array $parameters = []
    ) {
      LogHelper::add(__CLASS__ . ':' . 'BEGIN ModelBo $parameters:');
      foreach ($parameters as $key => $value) { LogHelper::add(__CLASS__ . ':' . $key . '=>' . $value); };
      LogHelper::add(__CLASS__ . ':' . 'END ModelBo $parameters!');
      $this->actor_name_plural  = $actor_name_plural;
      $this->actor_bo           = $actor_bo;
      $this->actor_attribute_bo = $actor_attribute_bo;
      $this->actor              = $actor_bo->getDao()->get(
        [
          'where' => [
            'name_plural' => StringHelper::getUnderScoresReplacedWithSpaces($this->actor_name_plural)
          ]
        ]
      )[0];
      $this->actor_name_singular = $this->actor['name'];
      # Backup check to retrieve actor by singular name...
      # Maybe implement a function to retrieve singular/plural by
      #   counterpart name... [artidas]
      if (is_null($this->actor)) {
        $this->actor = $actor_bo->getDao()->get(
          [
            'where' => [
              'name' => StringHelper::getUnderScoresReplacedWithSpaces($this->actor_name_plural)
            ]
          ]
        )[0];
        $this->actor_name_plural  = $this->actor['name_plural'];

        if (is_null($this->actor)) {
          throw new Exception("Cannot find Actor record for request: \"$this->actor_name_plural\"");
        }
      }

      $this->actor_attributes = $this->actor_attribute_bo->getDao()->get(
        [
          'where' => [
            'actor_id' => $this->actor['id']
          ]
        ]
      );
      $this->dao = new ModelDao(
        (new MysqlDatabaseBo()),
        $this->actor,
        $this->actor_attributes
      );
      $this->do = new ModelDo(
        $this->actor_attributes,
        $parameters
      );
      $this->records = $this->dao->get();
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getActor() {
      return $this->actor;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getActorAttributes() {
      return $this->actor_attributes;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getRecords() {
      $this->records = $this->dao->get();

      return $this->records;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getDao() {
      return $this->dao;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getDo() {
      return $this->do;
    }

  }

?>
