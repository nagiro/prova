<?php

/**
 * Base class that represents a row from the 'incidencies' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Sep  1 14:15:03 2009
 *
 * @package    lib.model.om
 */
abstract class BaseIncidencies extends BaseObject  implements Persistent {


  const PEER = 'IncidenciesPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        IncidenciesPeer
	 */
	protected static $peer;

	/**
	 * The value for the idincidencia field.
	 * @var        int
	 */
	protected $idincidencia;

	/**
	 * The value for the quiinforma field.
	 * @var        int
	 */
	protected $quiinforma;

	/**
	 * The value for the quiresol field.
	 * @var        int
	 */
	protected $quiresol;

	/**
	 * The value for the titol field.
	 * @var        string
	 */
	protected $titol;

	/**
	 * The value for the descripcio field.
	 * @var        string
	 */
	protected $descripcio;

	/**
	 * The value for the estat field.
	 * @var        int
	 */
	protected $estat;

	/**
	 * The value for the dataalta field.
	 * @var        string
	 */
	protected $dataalta;

	/**
	 * The value for the dataresolucio field.
	 * @var        string
	 */
	protected $dataresolucio;

	/**
	 * @var        Usuaris
	 */
	protected $aUsuarisRelatedByQuiinforma;

	/**
	 * @var        Usuaris
	 */
	protected $aUsuarisRelatedByQuiresol;

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

	/**
	 * Initializes internal state of BaseIncidencies object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
	}

	/**
	 * Get the [idincidencia] column value.
	 * 
	 * @return     int
	 */
	public function getIdincidencia()
	{
		return $this->idincidencia;
	}

	/**
	 * Get the [quiinforma] column value.
	 * 
	 * @return     int
	 */
	public function getQuiinforma()
	{
		return $this->quiinforma;
	}

	/**
	 * Get the [quiresol] column value.
	 * 
	 * @return     int
	 */
	public function getQuiresol()
	{
		return $this->quiresol;
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
	 * Get the [descripcio] column value.
	 * 
	 * @return     string
	 */
	public function getDescripcio()
	{
		return $this->descripcio;
	}

	/**
	 * Get the [estat] column value.
	 * 
	 * @return     int
	 */
	public function getEstat()
	{
		return $this->estat;
	}

	/**
	 * Get the [optionally formatted] temporal [dataalta] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDataalta($format = 'Y-m-d')
	{
		if ($this->dataalta === null) {
			return null;
		}


		if ($this->dataalta === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->dataalta);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->dataalta, true), $x);
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
	 * Get the [optionally formatted] temporal [dataresolucio] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDataresolucio($format = 'Y-m-d')
	{
		if ($this->dataresolucio === null) {
			return null;
		}


		if ($this->dataresolucio === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->dataresolucio);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->dataresolucio, true), $x);
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
	 * Set the value of [idincidencia] column.
	 * 
	 * @param      int $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setIdincidencia($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idincidencia !== $v) {
			$this->idincidencia = $v;
			$this->modifiedColumns[] = IncidenciesPeer::IDINCIDENCIA;
		}

		return $this;
	} // setIdincidencia()

	/**
	 * Set the value of [quiinforma] column.
	 * 
	 * @param      int $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setQuiinforma($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->quiinforma !== $v) {
			$this->quiinforma = $v;
			$this->modifiedColumns[] = IncidenciesPeer::QUIINFORMA;
		}

		if ($this->aUsuarisRelatedByQuiinforma !== null && $this->aUsuarisRelatedByQuiinforma->getUsuariid() !== $v) {
			$this->aUsuarisRelatedByQuiinforma = null;
		}

		return $this;
	} // setQuiinforma()

	/**
	 * Set the value of [quiresol] column.
	 * 
	 * @param      int $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setQuiresol($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->quiresol !== $v) {
			$this->quiresol = $v;
			$this->modifiedColumns[] = IncidenciesPeer::QUIRESOL;
		}

		if ($this->aUsuarisRelatedByQuiresol !== null && $this->aUsuarisRelatedByQuiresol->getUsuariid() !== $v) {
			$this->aUsuarisRelatedByQuiresol = null;
		}

		return $this;
	} // setQuiresol()

	/**
	 * Set the value of [titol] column.
	 * 
	 * @param      string $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setTitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->titol !== $v) {
			$this->titol = $v;
			$this->modifiedColumns[] = IncidenciesPeer::TITOL;
		}

		return $this;
	} // setTitol()

	/**
	 * Set the value of [descripcio] column.
	 * 
	 * @param      string $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setDescripcio($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->descripcio !== $v) {
			$this->descripcio = $v;
			$this->modifiedColumns[] = IncidenciesPeer::DESCRIPCIO;
		}

		return $this;
	} // setDescripcio()

	/**
	 * Set the value of [estat] column.
	 * 
	 * @param      int $v new value
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setEstat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->estat !== $v) {
			$this->estat = $v;
			$this->modifiedColumns[] = IncidenciesPeer::ESTAT;
		}

		return $this;
	} // setEstat()

	/**
	 * Sets the value of [dataalta] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setDataalta($v)
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

		if ( $this->dataalta !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->dataalta !== null && $tmpDt = new DateTime($this->dataalta)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->dataalta = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = IncidenciesPeer::DATAALTA;
			}
		} // if either are not null

		return $this;
	} // setDataalta()

	/**
	 * Sets the value of [dataresolucio] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Incidencies The current object (for fluent API support)
	 */
	public function setDataresolucio($v)
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

		if ( $this->dataresolucio !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->dataresolucio !== null && $tmpDt = new DateTime($this->dataresolucio)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->dataresolucio = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = IncidenciesPeer::DATARESOLUCIO;
			}
		} // if either are not null

		return $this;
	} // setDataresolucio()

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
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array())) {
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

			$this->idincidencia = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->quiinforma = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->quiresol = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->titol = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->descripcio = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->estat = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->dataalta = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->dataresolucio = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = IncidenciesPeer::NUM_COLUMNS - IncidenciesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Incidencies object", $e);
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

		if ($this->aUsuarisRelatedByQuiinforma !== null && $this->quiinforma !== $this->aUsuarisRelatedByQuiinforma->getUsuariid()) {
			$this->aUsuarisRelatedByQuiinforma = null;
		}
		if ($this->aUsuarisRelatedByQuiresol !== null && $this->quiresol !== $this->aUsuarisRelatedByQuiresol->getUsuariid()) {
			$this->aUsuarisRelatedByQuiresol = null;
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
			$con = Propel::getConnection(IncidenciesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = IncidenciesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUsuarisRelatedByQuiinforma = null;
			$this->aUsuarisRelatedByQuiresol = null;
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

    foreach (sfMixer::getCallables('BaseIncidencies:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IncidenciesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			IncidenciesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseIncidencies:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
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

    foreach (sfMixer::getCallables('BaseIncidencies:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IncidenciesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseIncidencies:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			IncidenciesPeer::addInstanceToPool($this);
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

			if ($this->aUsuarisRelatedByQuiinforma !== null) {
				if ($this->aUsuarisRelatedByQuiinforma->isModified() || $this->aUsuarisRelatedByQuiinforma->isNew()) {
					$affectedRows += $this->aUsuarisRelatedByQuiinforma->save($con);
				}
				$this->setUsuarisRelatedByQuiinforma($this->aUsuarisRelatedByQuiinforma);
			}

			if ($this->aUsuarisRelatedByQuiresol !== null) {
				if ($this->aUsuarisRelatedByQuiresol->isModified() || $this->aUsuarisRelatedByQuiresol->isNew()) {
					$affectedRows += $this->aUsuarisRelatedByQuiresol->save($con);
				}
				$this->setUsuarisRelatedByQuiresol($this->aUsuarisRelatedByQuiresol);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = IncidenciesPeer::IDINCIDENCIA;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = IncidenciesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdincidencia($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += IncidenciesPeer::doUpdate($this, $con);
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

			if ($this->aUsuarisRelatedByQuiinforma !== null) {
				if (!$this->aUsuarisRelatedByQuiinforma->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuarisRelatedByQuiinforma->getValidationFailures());
				}
			}

			if ($this->aUsuarisRelatedByQuiresol !== null) {
				if (!$this->aUsuarisRelatedByQuiresol->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuarisRelatedByQuiresol->getValidationFailures());
				}
			}


			if (($retval = IncidenciesPeer::doValidate($this, $columns)) !== true) {
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
		$pos = IncidenciesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdincidencia();
				break;
			case 1:
				return $this->getQuiinforma();
				break;
			case 2:
				return $this->getQuiresol();
				break;
			case 3:
				return $this->getTitol();
				break;
			case 4:
				return $this->getDescripcio();
				break;
			case 5:
				return $this->getEstat();
				break;
			case 6:
				return $this->getDataalta();
				break;
			case 7:
				return $this->getDataresolucio();
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
		$keys = IncidenciesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdincidencia(),
			$keys[1] => $this->getQuiinforma(),
			$keys[2] => $this->getQuiresol(),
			$keys[3] => $this->getTitol(),
			$keys[4] => $this->getDescripcio(),
			$keys[5] => $this->getEstat(),
			$keys[6] => $this->getDataalta(),
			$keys[7] => $this->getDataresolucio(),
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
		$pos = IncidenciesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdincidencia($value);
				break;
			case 1:
				$this->setQuiinforma($value);
				break;
			case 2:
				$this->setQuiresol($value);
				break;
			case 3:
				$this->setTitol($value);
				break;
			case 4:
				$this->setDescripcio($value);
				break;
			case 5:
				$this->setEstat($value);
				break;
			case 6:
				$this->setDataalta($value);
				break;
			case 7:
				$this->setDataresolucio($value);
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
		$keys = IncidenciesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdincidencia($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setQuiinforma($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setQuiresol($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTitol($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescripcio($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEstat($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDataalta($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDataresolucio($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(IncidenciesPeer::DATABASE_NAME);

		if ($this->isColumnModified(IncidenciesPeer::IDINCIDENCIA)) $criteria->add(IncidenciesPeer::IDINCIDENCIA, $this->idincidencia);
		if ($this->isColumnModified(IncidenciesPeer::QUIINFORMA)) $criteria->add(IncidenciesPeer::QUIINFORMA, $this->quiinforma);
		if ($this->isColumnModified(IncidenciesPeer::QUIRESOL)) $criteria->add(IncidenciesPeer::QUIRESOL, $this->quiresol);
		if ($this->isColumnModified(IncidenciesPeer::TITOL)) $criteria->add(IncidenciesPeer::TITOL, $this->titol);
		if ($this->isColumnModified(IncidenciesPeer::DESCRIPCIO)) $criteria->add(IncidenciesPeer::DESCRIPCIO, $this->descripcio);
		if ($this->isColumnModified(IncidenciesPeer::ESTAT)) $criteria->add(IncidenciesPeer::ESTAT, $this->estat);
		if ($this->isColumnModified(IncidenciesPeer::DATAALTA)) $criteria->add(IncidenciesPeer::DATAALTA, $this->dataalta);
		if ($this->isColumnModified(IncidenciesPeer::DATARESOLUCIO)) $criteria->add(IncidenciesPeer::DATARESOLUCIO, $this->dataresolucio);

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
		$criteria = new Criteria(IncidenciesPeer::DATABASE_NAME);

		$criteria->add(IncidenciesPeer::IDINCIDENCIA, $this->idincidencia);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdincidencia();
	}

	/**
	 * Generic method to set the primary key (idincidencia column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdincidencia($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Incidencies (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setQuiinforma($this->quiinforma);

		$copyObj->setQuiresol($this->quiresol);

		$copyObj->setTitol($this->titol);

		$copyObj->setDescripcio($this->descripcio);

		$copyObj->setEstat($this->estat);

		$copyObj->setDataalta($this->dataalta);

		$copyObj->setDataresolucio($this->dataresolucio);


		$copyObj->setNew(true);

		$copyObj->setIdincidencia(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Incidencies Clone of current object.
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
	 * @return     IncidenciesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new IncidenciesPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Usuaris object.
	 *
	 * @param      Usuaris $v
	 * @return     Incidencies The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUsuarisRelatedByQuiinforma(Usuaris $v = null)
	{
		if ($v === null) {
			$this->setQuiinforma(NULL);
		} else {
			$this->setQuiinforma($v->getUsuariid());
		}

		$this->aUsuarisRelatedByQuiinforma = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Usuaris object, it will not be re-added.
		if ($v !== null) {
			$v->addIncidenciesRelatedByQuiinforma($this);
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
	public function getUsuarisRelatedByQuiinforma(PropelPDO $con = null)
	{
		if ($this->aUsuarisRelatedByQuiinforma === null && ($this->quiinforma !== null)) {
			$c = new Criteria(UsuarisPeer::DATABASE_NAME);
			$c->add(UsuarisPeer::USUARIID, $this->quiinforma);
			$this->aUsuarisRelatedByQuiinforma = UsuarisPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUsuarisRelatedByQuiinforma->addIncidenciessRelatedByQuiinforma($this);
			 */
		}
		return $this->aUsuarisRelatedByQuiinforma;
	}

	/**
	 * Declares an association between this object and a Usuaris object.
	 *
	 * @param      Usuaris $v
	 * @return     Incidencies The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUsuarisRelatedByQuiresol(Usuaris $v = null)
	{
		if ($v === null) {
			$this->setQuiresol(NULL);
		} else {
			$this->setQuiresol($v->getUsuariid());
		}

		$this->aUsuarisRelatedByQuiresol = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Usuaris object, it will not be re-added.
		if ($v !== null) {
			$v->addIncidenciesRelatedByQuiresol($this);
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
	public function getUsuarisRelatedByQuiresol(PropelPDO $con = null)
	{
		if ($this->aUsuarisRelatedByQuiresol === null && ($this->quiresol !== null)) {
			$c = new Criteria(UsuarisPeer::DATABASE_NAME);
			$c->add(UsuarisPeer::USUARIID, $this->quiresol);
			$this->aUsuarisRelatedByQuiresol = UsuarisPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUsuarisRelatedByQuiresol->addIncidenciessRelatedByQuiresol($this);
			 */
		}
		return $this->aUsuarisRelatedByQuiresol;
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

			$this->aUsuarisRelatedByQuiinforma = null;
			$this->aUsuarisRelatedByQuiresol = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseIncidencies:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseIncidencies::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseIncidencies
