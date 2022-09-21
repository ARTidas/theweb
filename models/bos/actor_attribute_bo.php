<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ActorAttributeBo {
		const VALUE_FORM_TYPE_SELECT   = 'select';
		const VALUE_FORM_TYPE_TEXTAREA = 'textarea';

		const VALUE_FORM_SOURCE_ACTOR = 'actor';
		const VALUE_FORM_SOURCE_BO    = 'bo';

		const VALUE_DATA_TYPE_FLOAT = 'float';

		protected $dao;
		protected $actor_attributes;

    public static $data_type_values = [
      'int(11)',
			self::VALUE_DATA_TYPE_FLOAT,
      'varchar(10)',
      'varchar(45)',
      'varchar(128)',
			'varchar(256)',
      'text',
      'tinyint(4)',
			'datetime',
    ];
		public static $form_type_values = [
      'text', # This defaults to null, null defaults to this... [artidas]
			'textarea',
			self::VALUE_FORM_TYPE_SELECT,
			'checkbox',
    ];
		public static $form_source_values = [
      self::VALUE_FORM_SOURCE_ACTOR,
			self::VALUE_FORM_SOURCE_BO,
    ];

		/* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function __construct(ActorAttributeDao $dao) {
      $this->dao = $dao;
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public function getDao() {
      return $this->dao;
    }

  }
?>
