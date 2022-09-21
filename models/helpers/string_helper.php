<?php
  /* ********************************************************
   * ********************************************************
   * ********************************************************/
  Class StringHelper {

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getLink(string $input) {
      return preg_replace(
        '/\s+/',
        '_',
        strtolower(
          $input
        )
      );
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getUnderScoresReplacedWithSpaces(string $input) {
      return str_replace(
        '_',
        ' ',
        strtolower(
          $input
        )
      );
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getSpacesReplacedWithUnderScores(string $input) {
      return str_replace(
        ' ',
        '_',
        strtolower(
          $input
        )
      );
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getHumanReadable(string $input) {
      return str_replace(
        '_',
        ' ',
        ucfirst(
          $input
        )
      );
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getBoNameFromActorLinkSingularName(string $input) {
      return str_replace(
        ' ',
        '',
        ucwords(
          str_replace(
            '_',
            ' ',
            $input
          )
        )
      ) . 'Bo';
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getActorNameFromIdActorAttributeName(string $input) {
      return str_replace(
        '_id',
        '',
        $input
      );
    }

    /* ********************************************************
  	 * ********************************************************
  	 * ********************************************************/
    public static function getActorTableNameFromIdActorAttributeName(string $input) {
      $model_bo = new ModelBo(
        self::getActorNameFromIdActorAttributeName($input),
        new ActorBo(new ActorDao((new MysqlDatabaseBo()))),
        new ActorAttributeBo(new ActorAttributeDao((new MysqlDatabaseBo())))
      );

      return $model_bo->actor_name_plural;
    }

  }

?>
