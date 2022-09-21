<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ActorDo extends AbstractDo {
		public $name;
    public $name_plural;
    public $description;

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function __construct(array $parameters) {
      foreach ($this as $key => $value) {
				if (is_integer($key)) {
					continue;
				}

        if (
          $key == 'name' ||
          $key == 'name_plural'
        ) {
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
        if (
          $key = 'name' ||
          $key = 'name_plural'
        ) {
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
        if (
          $key == 'name' ||
          $key == 'name_plural'
        ) {
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
