<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ModelDo {
		public $attributes;
		public $parameters = [];

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function __construct(
      array $attributes,
      array $parameters = []
    ) {
			LogHelper::add(__CLASS__ . ':' . 'CONSTRUCTING ModelDo...');
      $this->attributes = $attributes;
			LogHelper::add(__CLASS__ . ':' . 'BEGIN ModelDo $parameters:');
      foreach ($parameters as $key => $value) { LogHelper::add(__CLASS__ . ':' . $key . '=>' . $value); };
      LogHelper::add(__CLASS__ . ':' . 'END ModelDo $parameters!');

			LogHelper::add(__CLASS__ . ':' . 'BEGIN ModelDo set $this->attributes:');
      foreach ($this->attributes as $attribute) {
        #$this->$attribute['name'] = $parameters[$attribute['name']];
				$this->parameters[$attribute['name']] = $parameters[$attribute['name']];
				#LogHelper::add(__CLASS__ . ':' . 'ModelDo attribute: "' . $attribute['name'] . '", set to: "' . $this->parameters['name'] . '"');
				LogHelper::add(__CLASS__ . ':' . 'ModelDo attribute: "' . $attribute['name'] . '", set to: "' . $this->parameters[$attribute['name']] . '"');
      }
			LogHelper::add(__CLASS__ . ':' . 'END ModelDo set $this->attributes!');
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getParameters() {
      return $this->attributes;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getCreateParameters() {
			LogHelper::add(__CLASS__ . ':' . 'BEGIN ModelDo record creation $parameters:');
      $parameters = [];

      foreach ($this->attributes as $attribute) {
        if (
          $attribute['name'] == 'id' ||
          $attribute['name'] == 'actor_id' ||
          $attribute['name'] == 'is_active' ||
          $attribute['name'] == 'created_at' ||
          $attribute['name'] == 'updated_at' ||
          $attribute['name'] == 'create'
        ) {
          continue;
        }
        else {
					LogHelper::add(__CLASS__ . ': ' . 'Parameter "' . $attribute['name'] . '", set to: "' . $this->$attribute['name'] . '"');
          #$parameters[] = $this->$attribute['name'];
					$parameters[] = $this->parameters[$attribute['name']];
        }
      }

			LogHelper::add(__CLASS__ . ':' . 'END ModelDo record creation $parameters!');

      return $parameters;
    }

  }
?>
