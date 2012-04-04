<?php

/**
 * Base class that represents a row from the 'missatges' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 04/03/12 09:56:42
 *
 * @package    lib.model.om
 */
abstract class BaseMissatges extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MissatgesPeer
	 */
	protected static $peer;

	/**
	 * The value for the missatgeid field.
	 * @var        int
	 */
	protected $missatgeid;

	/**
	 * The value for the usuaris_usuariid field.
	 * @var        int
	 */
	protected $usuaris_usuariid;

	/**
	 * The value for the titol field.
	 * @var        string
	 */
	protected $titol;

	/**
	 * The value for the text field.
	 * @var        string
	 */
	protected $text;

	/**
	 * The value for the date field.
	 * @var        string
	 */
	protected $date;

	/**
	 * The value for the publicacio field.
	 * @var        string
	 */
	protected $publicacio;

	/**
	 * The value for the site_id field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $site_id;

	/**
	 * The value for the actiu field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $actiu;

	/**
	 * The value for the isglobal field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $isglobal;

	/**
	 * @var        Usuaris
	 */
	protected $aUsuaris;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'MissatgesPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->site_id = 1;
		$this->actiu = 1;
		$this->isglobal = 0;
	}

	/**
	 * Initializes internal state of BaseMissatges object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [missatgeid] column value.
	 * 
	 * @return     int
	 */
	public function getMissatgeid()
	{
		return $this->missatgeid;
	}

	/**
	 * Get the [usuaris_usuariid] column value.
	 * 
	 * @return     int
	 */
	public function getUsuarisUsuariid()
	{
		return $this->usuaris_usuariid;
	}

	/**
	 * Get the [titol] column value.
	 * 
	 * @return     string
	 */
	public function getTitol()
	{
		return $this->titol;
	}

	/**
	 * Get the [text] column value.
	 * 
	 * @return     string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * Get the [optionally formatted] temporal [date] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDate($format = 'Y-m-d H:i:s')
	{
		if ($this->date === null) {
			return null;
		}


		if ($this->date === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [publicacio] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getPublicacio($format = 'Y-m-d')
	{
		if ($this->publicacio === null) {
			return null;
		}


		if ($this->publicacio === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->publicacio);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->publicacio, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [site_id] column value.
	 * 
	 * @return     int
	 */
	public function getSiteId()
	{
		return $this->site_id;
	}

	/**
	 * Get the [actiu] column value.
	 * 
	 * @return     int
	 */
	public function getActiu()
	{
		return $this->actiu;
	}

	/**
	 * Get the [isglobal] column value.
	 * 
	 * @return     int
	 */
	public function getIsglobal()
	{
		return $this->isglobal;
	}

	/**
	 * Set the value of [missatgeid] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setMissatgeid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->missatgeid !== $v) {
			$this->missatgeid = $v;
			$this->modifiedColumns[] = MissatgesPeer::MISSATGEID;
		}

		return $this;
	} // setMissatgeid()

	/**
	 * Set the value of [usuaris_usuariid] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setUsuarisUsuariid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->usuaris_usuariid !== $v) {
			$this->usuaris_usuariid = $v;
			$this->modifiedColumns[] = MissatgesPeer::USUARIS_USUARIID;
		}

		if ($this->aUsuaris !== null && $this->aUsuaris->getUsuariid() !== $v) {
			$this->aUsuaris = null;
		}

		return $this;
	} // setUsuarisUsuariid()

	/**
	 * Set the value of [titol] column.
	 * 
	 * @param      string $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setTitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->titol !== $v) {
			$this->titol = $v;
			$this->modifiedColumns[] = MissatgesPeer::TITOL;
		}

		return $this;
	} // setTitol()

	/**
	 * Set the value of [text] column.
	 * 
	 * @param      string $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setText($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->text !== $v) {
			$this->text = $v;
			$this->modifiedColumns[] = MissatgesPeer::TEXT;
		}

		return $this;
	} // setText()

	/**
	 * Sets the value of [date] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setDate($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->date !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->date = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = MissatgesPeer::DATE;
			}
		} // if either are not null

		return $this;
	} // setDate()

	/**
	 * Sets the value of [publicacio] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setPublicacio($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->publicacio !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->publicacio !== null && $tmpDt = new DateTime($this->publicacio)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->publicacio = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = MissatgesPeer::PUBLICACIO;
			}
		} // if either are not null

		return $this;
	} // setPublicacio()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v || $this->isNew()) {
			$this->site_id = $v;
			$this->modifiedColumns[] = MissatgesPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = MissatgesPeer::ACTIU;
		}

		return $this;
	} // setActiu()

	/**
	 * Set the value of [isglobal] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatges The current object (for fluent API support)
	 */
	public function setIsglobal($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->isglobal !== $v || $this->isNew()) {
			$this->isglobal = $v;
			$this->modifiedColumns[] = MissatgesPeer::ISGLOBAL;
		}

		return $this;
	} // setIsglobal()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->site_id !== 1) {
				return false;
			}

			if ($this->actiu !== 1) {
				return false;
			}

			if ($this->isglobal !== 0) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->missatgeid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->usuaris_usuariid = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->titol = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->text = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->date = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->publicacio = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->site_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->actiu = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->isglobal = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 9; // 9 = MissatgesPeer::NUM_COLUMNS - MissatgesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Missatges object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aUsuaris !== null && $this->usuaris_usuariid !== $this->aUsuaris->getUsuariid()) {
			$this->aUsuaris = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MissatgesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = MissatgesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUsuaris = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MissatgesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseMissatges:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				MissatgesPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseMissatges:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MissatgesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseMissatges:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseMissatges:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				MissatgesPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUsuaris !== null) {
				if ($this->aUsuaris->isModified() || $this->aUsuaris->isNew()) {
					$affectedRows += $this->aUsuaris->save($con);
				}
				$this->setUsuaris($this->aUsuaris);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = MissatgesPeer::MISSATGEID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MissatgesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setMissatgeid($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MissatgesPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUsuaris !== null) {
				if (!$this->aUsuaris->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuaris->getValidationFailures());
				}
			}


			if (($retval = MissatgesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MissatgesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getMissatgeid();
				break;
			case 1:
				return $this->getUsuarisUsuariid();
				break;
			case 2:
				return $this->getTitol();
				break;
			case 3:
				return $this->getText();
				break;
			case 4:
				return $this->getDate();
				break;
			case 5:
				return $this->getPublicacio();
				break;
			case 6:
				return $this->getSiteId();
				break;
			case 7:
				return $this->getActiu();
				break;
			case 8:
				return $this->getIsglobal();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = MissatgesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getMissatgeid(),
			$keys[1] => $this->getUsuarisUsuariid(),
			$keys[2] => $this->getTitol(),
			$keys[3] => $this->getText(),
			$keys[4] => $this->getDate(),
			$keys[5] => $this->getPublicacio(),
			$keys[6] => $this->getSiteId(),
			$keys[7] => $this->getActiu(),
			$keys[8] => $this->getIsglobal(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MissatgesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setMissatgeid($value);
				break;
			case 1:
				$this->setUsuarisUsuariid($value);
				break;
			case 2:
				$this->setTitol($value);
				break;
			case 3:
				$this->setText($value);
				break;
			case 4:
				$this->setDate($value);
				break;
			case 5:
				$this->setPublicacio($value);
				break;
			case 6:
				$this->setSiteId($value);
				break;
			case 7:
				$this->setActiu($value);
				break;
			case 8:
				$this->setIsglobal($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MissatgesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setMissatgeid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsuarisUsuariid($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitol($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setText($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPublicacio($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSiteId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setActiu($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsglobal($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MissatgesPeer::DATABASE_NAME);

		if ($this->isColumnModified(MissatgesPeer::MISSATGEID)) $criteria->add(MissatgesPeer::MISSATGEID, $this->missatgeid);
		if ($this->isColumnModified(MissatgesPeer::USUARIS_USUARIID)) $criteria->add(MissatgesPeer::USUARIS_USUARIID, $this->usuaris_usuariid);
		if ($this->isColumnModified(MissatgesPeer::TITOL)) $criteria->add(MissatgesPeer::TITOL, $this->titol);
		if ($this->isColumnModified(MissatgesPeer::TEXT)) $criteria->add(MissatgesPeer::TEXT, $this->text);
		if ($this->isColumnModified(MissatgesPeer::DATE)) $criteria->add(MissatgesPeer::DATE, $this->date);
		if ($this->isColumnModified(MissatgesPeer::PUBLICACIO)) $criteria->add(MissatgesPeer::PUBLICACIO, $this->publicacio);
		if ($this->isColumnModified(MissatgesPeer::SITE_ID)) $criteria->add(MissatgesPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(MissatgesPeer::ACTIU)) $criteria->add(MissatgesPeer::ACTIU, $this->actiu);
		if ($this->isColumnModified(MissatgesPeer::ISGLOBAL)) $criteria->add(MissatgesPeer::ISGLOBAL, $this->isglobal);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MissatgesPeer::DATABASE_NAME);

		$criteria->add(MissatgesPeer::MISSATGEID, $this->missatgeid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getMissatgeid();
	}

	/**
	 * Generic method to set the primary key (missatgeid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setMissatgeid($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Missatges (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUsuarisUsuariid($this->usuaris_usuariid);

		$copyObj->setTitol($this->titol);

		$copyObj->setText($this->text);

		$copyObj->setDate($this->date);

		$copyObj->setPublicacio($this->publicacio);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);

		$copyObj->setIsglobal($this->isglobal);


		$copyObj->setNew(true);

		$copyObj->setMissatgeid(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Missatges Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     MissatgesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MissatgesPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Usuaris object.
	 *
	 * @param      Usuaris $v
	 * @return     Missatges The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUsuaris(Usuaris $v = null)
	{
		if ($v === null) {
			$this->setUsuarisUsuariid(NULL);
		} else {
			$this->setUsuarisUsuariid($v->getUsuariid());
		}

		$this->aUsuaris = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Usuaris object, it will not be re-added.
		if ($v !== null) {
			$v->addMissatges($this);
		}

		return $this;
	}


	/**
	 * Get the associated Usuaris object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Usuaris The associated Usuaris object.
	 * @throws     PropelException
	 */
	public function getUsuaris(PropelPDO $con = null)
	{
		if ($this->aUsuaris === null && ($this->usuaris_usuariid !== null)) {
			$this->aUsuaris = UsuarisPeer::retrieveByPk($this->usuaris_usuariid);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUsuaris->addMissatgess($this);
			 */
		}
		return $this->aUsuaris;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aUsuaris = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseMissatges:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseMissatges::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseMissatges
