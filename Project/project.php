<!-- The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

<html>
    <head>
        <title>Pokedex</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        <style>
          body {
            font-family: 'Poppins', Arial;
            font-weight:'400';
            padding:30px auto;
          }
          h1 {
            text-align:center;
          }
          input[type=submit], input[type=reset], input[type=button] {
            background:#444;
            padding:10px 20px;
            color:#fff;
            font-family:'Poppins', Arial;
            font-weight:600;
            text-transform:uppercase;
            border:none;
          }
        </style>
    </head>

    <body>
        <h1>CS304 POKEMON DATABASE</h1>
        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Generate new Pokemon</h2>
        <form method="POST" action="project.php">
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            <!-- Number: <input type="text" name="insNo"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br /> -->

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>
<!--
        <hr />
        <h2>Update Species Name in Species Table</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
        <form method="POST" action="project.php">
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Old Name: <input type="text" name="oldName"> <br /><br />
            New Name: <input type="text" name="newName"> <br /><br />
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form> -->

        <hr />

        <h2>Count the Tuples in Tables</h2>
        <form method="GET" action="project.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

        <hr />


        <h2>Display Your Pokemon</h2>
        <form method="GET" action="project.php">
            <input type="hidden" id="displayPokemon" name="displayPokemonRequest">
            <input type="submit" name="displayPokemon"></p>
        </form>

        <hr />

        <?php

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_kfoong", "a58380510", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old tables
            echo("Resetting...");
            executePlainSQL("DROP TABLE p_uses");
            executePlainSQL("DROP TABLE is_of");
            executePlainSQL("DROP TABLE Pokemon");

            echo("Clearing tables...");
            executePlainSQL("CREATE TABLE Pokemon (
              ID					INT,
            	Nickname		VARCHAR(255),
            	Gender			VARCHAR(20),
            	TimeCaught		TIMESTAMP,
            	PRIMARY KEY (Nickname),
            	FOREIGN KEY (ID) REFERENCES SPECIES
            )");
            executePlainSQL("CREATE TABLE is_of (
            	Nickname		VARCHAR(255),
            	ID					INT,
            	PRIMARY KEY (Nickname, ID),
            	FOREIGN KEY (Nickname) REFERENCES Pokemon,
            	FOREIGN KEY (ID) REFERENCES Species
            )");
            executePlainSQL("CREATE TABLE p_uses (
              	Nickname		VARCHAR(255),
              	ItemName		VARCHAR(20),
              	PRIMARY KEY (Nickname, ItemName),
              	FOREIGN KEY (Nickname) REFERENCES Pokemon
            )");
            // executePlainSQL("DELETE FROM Pokemon");
            // executePlainSQL("DELETE FROM is_of");
            // executePlainSQL("DELETE FROM p_uses");
            echo("Done!");
            // executePlainSQL("CREATE TABLE statTable (hp int, attack int, spAttack int, defence int, spDefence int, speed int, increase varchar(30), decrease varchar(30))");
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            // $tuple = array (
            //     ":bind1" => $_POST['insNo'],
            //     ":bind2" => $_POST['insName']
            // );

            // $alltuples = array (
            //     $tuple
            // );
            //
            $rgen = 'agender';
            $rnum = rand(0,10)%2;
            if ( $rnum == 0) {
              $rgen = 'male';
            } else {
              $rgen = 'female';
            }
            $randomSpid = executePlainSQL("SELECT id FROM (SELECT id FROM Species ORDER BY DBMS_RANDOM.RANDOM) WHERE ROWNUM = 1");
            $randomSpidResult = OCI_Fetch_Array($randomSpid, OCI_BOTH);
            $randomSpname = executePlainSQL("SELECT SpName FROM Species WHERE id = $randomSpidResult[0]");
            $randomSpnameResult = OCI_Fetch_Array($randomSpname, OCI_BOTH);
            $newPokemon = executePlainSQL("INSERT INTO Pokemon VALUES ($randomSpidResult[0],'$randomSpnameResult[0]' , '$rgen', CURRENT_TIMESTAMP)");

            //  $sql = "SELECT id FROM (SELECT id FROM Species ORDER BY DBMS_RANDOM.RANDOM) WHERE ROWNUM = 1";
            // //$rdm = random_int(0,65);
            // //$sql = "SELECT id FROM Species WHERE id=$rdm";
            // $sql_n = "SELECT SpName FROM Species WHERE id=$sql";
            // $stid = oci_parse($db_conn, $sql_n);
            // oci_execute($stid);
            // $nrows = oci_fetch_all($stid, $res);
            // //echo "$nrows fetched<br>";
            // //var_dump($res);
            // $pid = $res['id'];
            echo "You caught a " . $rgen . " " . $randomSpnameResult[0] . "!";

            OCICommit($db_conn);
        }

        function handleUpdateRequest($old_name) {
            global $db_conn;

            $new_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            if(isset($_POST['newName'])) {
              executePlainSQL("UPDATE Pokemon SET nickname='" . $new_name . "' WHERE nickname='" . $old_name . "'");
              echo "Updated" . $new_name . "," . $old_name;
            }
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $resultSp = executePlainSQL("SELECT Count(*) FROM Species");
            if (($row = oci_fetch_row($resultSp)) != false) {
                echo "<br> The number of tuples in Species Table: " . $row[0] . "<br>";
            }

            $resultPm = executePlainSQL("SELECT Count(*) FROM Pokemon");
            if (($row = oci_fetch_row($resultPm)) != false) {
                echo "<br> The number of tuples in Pokemon Table: " . $row[0] . "<br>";
            }
        }

        function displayPokemon() {
            global $db_conn;

            $res = executePlainSQL("SELECT * FROM Pokemon");
            echo "<table>";
            while (($row = oci_fetch_row($res)) != false) {
              echo "<tr><td>". $row[0] . ", " . $row[1] . ", " . $row[2] . ", Caught on: " . $row[3] . "</td></tr>";
            }
            echo "</table>";
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            }

            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            } else if (array_key_exists('showTuples', $_GET)){
                showTuples();
            } else if (array_key_exists('displayPokemon', $_GET)) {
                displayPokemon();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['showTupleRequest']) || isset($_GET['displayPokemonRequest'])) {
        handleGETRequest();
    }
		?>
	</body>
</html>
