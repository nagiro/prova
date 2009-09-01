<?php

/**
 * Base class that represents a row from the 'subcategories_has_projectes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Sep  1 14:15:04 2009
 *
 * @package    lib.model.om
 */
abstract class BaseSubcategoriesHasProjectes extends BaseObject  implements Persistent {


  const PEER = 'SubcategoriesHasProjectesPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SubcategoriesHasProjectesPeer
	 */
	protected static $peer;

	/**
	 * The value for the subcategories_idsubcategories field.
	 * @var        int
	 */
	protected $subcategories_idsubcategories;

	/**
	 * The value for the projectes_idprojectes field.
	 * @var        int
	 */
	protected $projectes_idprojectes;

	/**
	 * @var        Subcategories
	 */
	protected $aSubcategories;

	/**
	 * @var        Projectes
	 */
	protected $aProjectes;

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
	 * Initializes internal state of BaseSubcategoriesHasProjectes object.
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
	 * Get the [subcategories_idsubcategories] column value.
	 * 
	 * @return     int
	 */
	public function getSubcategoriesIdsubcategories()
	{
		return $this->subcategories_idsubcategories;
	}

	/**
	 * Get the [projectes_idprojectes] column value.
	 * 
	 * @return     int
	 */
	public function getProjectesIdprojectes()
	{
		return $this->projectes_idprojectes;
	}

	/**
	 * Set the value of [subcategories_idsubcategories] column.
	 * 
	 * @param      int $v new value
	 * @return     SubcategoriesHasProjectes The current object (for fluent API support)
	 */
	public function setSubcategoriesIdsubcategories($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->subcategories_idsubcategories !== $v) {
			$this->subcategories_idsubcategories = $v;
			$this->modifiedColumns[] = SubcategoriesHasProjectesPeer::SUBCATEGORIES_IDSUBCATEGORIES;
		}

		if ($this->aSubcategories !== null && $this->aSubcategories->getIdsubcategories() !== $v) {
			$this->aSubcategories = null;
		}

		return $this;
	} // setSubcategoriesIdsubcategories()

	/**
	 * Set the value of [projectes_idprojectes] column.
	 * 
	 * @param      int $v new value
	 * @return     SubcategoriesHasProjectes The current object (for fluent API support)
	 */
	public function setProjectesIdprojectes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->projectes_idprojectes !== $v) {
			$this->projectes_idprojectes = $v;
			$this->modifiedColumns[] = SubcategoriesHasProjectesPeer::PROJECTES_IDPROJECTES;
		}

		if ($this->aProjectes !== null && $this->aProjectes->getIdprojectes() !== $v) {
			$this->aProjectes = null;
		}

		return $this;
	} // setProjectesIdprojectes()

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

			$this->subcategories_idsubcategories = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->projectes_idprojectes = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 2; // 2 = SubcategoriesHasProjectesPeer::NUM_COLUMNS - SubcategoriesHasProjectesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating SubcategoriesHasProjectes object", $e);
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

		if ($this->aSubcategories !== null && $this->subcategories_idsubcategories !== $this->aSubcategories->getIdsubcategories()) {
			$this->aSubcategories = null;
		}
		if ($this->aProjectes !== null && $this->projectes_idprojectes !== $this->aProjectes->getIdprojectes()) {
			$this->aProjectes = null;
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
			$con = Propel::getConnection(SubcategoriesHasProjectesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = SubcategoriesHasProjectesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aSubcategories = null;
			$this->aProjectes = null;
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

    foreach (sfMixer::getCallables('BaseSubcategoriesHasProjectes:delete:pre') as $callable)
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
			$con = Propel::getConnection(SubcategoriesHasProjectesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			SubcategoriesHasProjectesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSubcategoriesHasProjectes:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseSubcategoriesHasProjectes:save:pre') as $callable)
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
			$con = Propel::getConnection(SubcategoriesHasProjectesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSubcategoriesHasProjectes:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			SubcategoriesHasProjectesPeer::addInstanceToPool($this);
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

			if ($this->aSubcategories !== null) {
				if ($this->aSubcategories->isModified() || $this->aSubcategories->isNew()) {
					$affectedRows += $this->aSubcategories->save($con);
				}
				$this->setSubcategories($this->aSubcategories);
			}

			if ($this->aProjectes !== null) {
				if ($this->aProjectes->isModified() || $this->aProjectes->isNew()) {
					$affectedRows += $this->aProjectes->save($con);
				}
				$this->setProjectes($this->aProjectes);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SubcategoriesHasProjectesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += SubcategoriesHasProjectesPeer::doUpdate($this, $con);
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

			if ($this->aSubcategories !== null) {
				if (!$this->aSubcategories->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubcategories->getValidationFailures());
				}
			}

			if ($this->aProjectes !== null) {
				if (!$this->aProjectes->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProjectes->getValidationFailures());
				}
			}


			if (($retval = SubcategoriesHasProjectesPeer::doValidate($this, $columns)) !== true) {
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
		$pos = SubcategoriesHasProjectesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSubcategoriesIdsubcategories();
				break;
			case 1:
				return $this->getProjectesIdprojectes();
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
		$keys = SubcategoriesHasProjectesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getSubcategoriesIdsubcategories(),
			$keys[1] => $this->getProjectesIdprojectes(),
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
		$pos = SubcategoriesHasProjectesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSubcategoriesIdsubcategories($value);
				break;
			case 1:
				$this->setProjectesIdprojectes($value);
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
		$keys = SubcategoriesHasProjectesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setSubcategoriesIdsubcategories($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setProjectesIdprojectes($arr[$keys[1]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SubcategoriesHasProjectesPeer::DATABASE_NAME);

		if ($this->isColumnModified(SubcategoriesHasProjectesPeer::SUBCATEGORIES_IDSUBCATEGORIES)) $criteria->add(SubcategoriesHasProjectesPeer::SUBCATEGORIES_IDSUBCATEGORIES, $this->subcategories_idsubcategories);
		if ($this->isColumnModified(SubcategoriesHasProjectesPeer::PROJECTES_IDPROJECTES)) $criteria->add(SubcategoriesHasProjectesPeer::PROJECTES_IDPROJECTES, $this->projectes_idprojectes);

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
		$criteria = new Criteria(SubcategoriesHasProjectesPeer::DATABASE_NAME);

		$criteria->add(SubcategoriesHasProjectesPeer::SUBCATEGORIES_IDSUBCATEGORIES, $this->subcategories_idsubcategories);
		$criteria->add(SubcategoriesHasProjectesPeer::PROJECTES_IDPROJECTES, $this->projectes_idprojectes);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getSubcategoriesIdsubcategories();

		$pks[1] = $this->getProjectesIdprojectes();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setSubcategoriesIdsubcategories($keys[0]);

		$this->setProjectesIdprojectes($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of SubcategoriesHasProjectes (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setSubcategoriesIdsubcategories($this->subcategories_idsubcategories);

		$copyObj->setProjectesIdprojectes($this->projectes_idprojectes);


		$copyObj->setNew(true);

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
	 * @return     SubcategoriesHasProjectes Clone of current object.
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
	 * @return     SubcategoriesHasProjectesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SubcategoriesHasProjectesPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Subcategories object.
	 *
	 * @param      Subcategories $v
	 * @return     SubcategoriesHasProjectes The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setSubcategories(Subcategories $v = null)
	{
		if ($v === null) {
			$this->setSubcategoriesIdsubcategories(NULL);
		} else {
			$this->setSubcategoriesIdsubcategories($v->getIdsubcategories());
		}

		$this->aSubcategories = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Subcategories object, it will not be re-added.
		if ($v !== null) {
			$v->addSubcategoriesHasProjectes($this);
		}

		return $this;
	}


	/**
	 * Get the associated Subcategories object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Subcategories The associated Subcategories object.
	 * @throws     PropelException
	 */
	public function getSubcategories(PropelPDO $con = null)
	{
		if ($this->aSubcategories === null && ($this->subcategories_idsubcategories !== null)) {
			$c = new Criteria(SubcategoriesPeer::DATABASE_NAME);
			$c->add(SubcategoriesPeer::IDSUBCATEGORIES, $this->subcategories_idsubcategories);
			$this->aSubcategories = SubcategoriesPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aSubcategories->addSubcategoriesHasProjectess($this);
			 */
		}
		return $this->aSubcategories;
	}

	/**
	 * Declares an association between this object and a Projectes object.
	 *
	 * @param      Projectes $v
	 * @return     SubcategoriesHasProjectes The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setProjectes(Projectes $v = null)
	{
		if ($v === null) {
			$this->setProjectesIdprojectes(NULL);
		} else {
			$this->setProjectesIdprojectes($v->getIdprojectes());
		}

		$this->aProjectes = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Projectes object, it will not be re-added.
		if ($v !== null) {
			$v->addSubcategoriesHasProjectes($this);
		}

		return $this;
	}


	/**
	 * Get the associated Projectes object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Projectes The associated Projectes object.
	 * @throws     PropelException
	 */
	public function getProjectes(PropelPDO $con = null)
	{
		if ($this->aProjectes === null && ($this->projectes_idprojectes !== null)) {
			$c = new Criteria(ProjectesPeer::DATABASE_NAME);
			$c->add(ProjectesPeer::IDPROJECTES, $this->projectes_idprojectes);
			$this->aProjectes = ProjectesPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aProjectes->addSubcategoriesHasProjectess($this);
			 */
		}
		return $this->aProjectes;
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

			$this->aSubcategories = null;
			$this->aProjectes = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseSubcategoriesHasProjectes:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSubcategoriesHasProjectes::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseSubcategoriesHasProjectes
