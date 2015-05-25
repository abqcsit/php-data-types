Creating Data Types.

1. Add name of data type to the php constant ALLOWED_DATATYPES. All values are seperated by a
   comma.

2. Add a constant defining the allowed characters for the data type. The naming convention is
   VDM_A[DATATYPE].
	- The allowed data type character constants are regular expression used by pregmatch.

3. In the DataTypes folder is the file trait.datatype-def.php. A function must be added in the form
   of [datatype]_datatypes. This function is used to set the properties of the datatype.
	-function does not take any parameters
	-the array within the function must contain properties of the data type
	-array needs to be merged with the class var $this->data_types
	-in the function set_datatypes, a call to this function must be added
	-function must be in the private scope.

4. If the datatype will employ a path type naming for its' keys: 
	-it must be added to the elseif statement inside the foreach loop of the
	 function chkvar in the trait.datatype-chkvars.php file. 

5. If a new check val function was named in step 3 of the datatype properties, it must be created
   in the trait.datachecks.php file. 