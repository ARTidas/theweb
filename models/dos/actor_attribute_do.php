<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ActorAttributeDo extends AbstractDo {
		public $actor_id;
    public $name;
    public $data_type;
		public $form_type;
		public $form_source;
    public $description;
		public $sort_order;

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function __construct(array $parameters) {
      foreach ($this as $key => $value) {
        if ($key == 'name') {
          $this->$key = strtolower($parameters[$key]);
        } else {
          $this->$key = $parameters[$key];
        }
      }
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getParameters() {
      foreach ($this as $key => $value) {
        if ($key = 'name') {
          $parameters[$key] = $value;
        } else {
          $parameters[$key] = strtolower($value);
        }
      }
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getCreateParameters() {
      $parameters = [];

      foreach ($this as $key => $value) {
        if ($key == 'name') {
          $parameters[] = strtolower($value);
        }
        elseif (
          $key == 'id' ||
          $key == 'is_active' ||
          $key == 'created_at' ||
          $key == 'updated_at'
        ) {
        }
        elseif ($key == 'create') {
        }
        else {
          $parameters[] = $value;
        }
      }

      return $parameters;
    }

  }
?>
