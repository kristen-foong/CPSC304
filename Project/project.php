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
            padding:0px;
            margin:0px;
            position:relative;
          }
          #wrapper {
            position:relative;
            margin:30px 30px;
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
          footer {
            font-size:10px;
            text-align:center;
            width:100%;
            position:absolute;
            bottom:0px;
          }
          .inline {
            display:flex;
            align-items:center;
            flex-wrap:wrap;
          }
          .inline form {
            margin:2px;
          }
        </style>
    </head>

    <body>
      <div id="wrapper">
        <h1>CS304 POKEMON DATABASE</h1>

        <h2>General</h2>
        <div class="inline">

          <form method="POST" action="project.php">
              <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
              <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
              <input type="submit" value="Reset Tables" name="reset">
          </form>

            <!-- count tuples -->
            <form method="GET" action="project.php">
                <input type="hidden" id="countTupleRequest" name="countTupleRequest">
                <input type="submit" value ="Count Tuples In Tables" name="countTuples">
            </form>
        </div>

        <h2>Filter By Type</h2>
        <!-- count tuples -->
        <div class="inline">

          <!-- filter by type -->

          <form method="GET" action="project.php">
              <input type="hidden" id="getNormalPokemon" name="getNormalPokemon">
              <input type="submit" value ="Normal" name="getNormal">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getGrassPokemon" name="getGrassPokemon">
              <input type="submit" value ="Grass" name="getGrass">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getFirePokemon" name="getFirePokemon">
              <input type="submit" value ="Fire" name="getFire">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getWaterPokemon" name="getWaterPokemon">
              <input type="submit" value ="Water" name="getWater">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getGroundPokemon" name="getGroundPokemon">
              <input type="submit" value ="Ground" name="getGround">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getFlyingPokemon" name="getFlyingPokemon">
              <input type="submit" value ="Flying" name="getFlying">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getPoisonPokemon" name="getPoisonPokemon">
              <input type="submit" value ="Poison" name="getPoison">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getFightingPokemon" name="getFightingPokemon">
              <input type="submit" value ="Fighting" name="getFighting">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getBugPokemon" name="getBugPokemon">
              <input type="submit" value ="Bug" name="getBug">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getElectricPokemon" name="getElectricPokemon">
              <input type="submit" value ="Electric" name="getElectric">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getPsychicPokemon" name="getPsychicPokemon">
              <input type="submit" value ="Psychic" name="getPsychic">
          </form>

          <form method="GET" action="project.php">
              <input type="hidden" id="getFairyPokemon" name="getFairyPokemon">
              <input type="submit" value ="Fairy" name="getFairy">
          </form>

        </div>

        <hr>
        <h2>Manage Your Pokemon</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <div class="inline">

        <!-- generate pokemon -->
        <form method="POST" action="project.php">
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            <!-- Number: <input type="text" name="insNo"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br /> -->

            <input type="submit" value="Generate Pokemon" name="insertSubmit">
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

        <!-- display pokemon -->
        <form method="GET" action="project.php">
            <input type="hidden" id="displayPokemon" name="displayPokemonRequest">
            <input type="submit" value="Display Pokemon" name="displayPokemon">
        </form>
        <br>
        </div>

        <!-- release pokemon nickname -->
        <form method="POST" action="project.php">
            <input type="hidden" id="releasePokemonRequest" name="releasePokemonRequest">
            <input type="submit" value="Release Pokemon" name="releaseSubmit">
            <input type="text" name="ridID" placeholder="Enter OwnedID of Pokemon to Release">
        </form>



        <hr />

        <?php
        $ownedID = 0;
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
            $ownedID = 0;

            echo("Clearing tables...");
            executePlainSQL("CREATE TABLE Pokemon (
            	ID					INT,
            	Nickname		VARCHAR(255),
            	Gender			VARCHAR(20),
            	TimeCaught		TIMESTAMP,
            	OwnedID			INT,
            	PRIMARY KEY (OwnedID),
            	FOREIGN KEY (ID) REFERENCES SPECIES
            )");
            executePlainSQL("CREATE TABLE is_of (
            	OwnedID	     	INT,
            	ID						INT,
            	PRIMARY KEY (OwnedID, ID),
            	FOREIGN KEY (OwnedID) REFERENCES Pokemon,
            	FOREIGN KEY (ID) REFERENCES Species
            )");
            executePlainSQL("CREATE TABLE p_uses (
            	OwnedID		    INT,
            	ItemName			VARCHAR(20),
            	PRIMARY KEY (OwnedID, ItemName),
            	FOREIGN KEY (OwnedID) REFERENCES Pokemon
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

            $resultSp = executePlainSQL("SELECT Count(*) FROM Pokemon");
            $row = oci_fetch_row($resultSp);
            $newPokemon = executePlainSQL("INSERT INTO Pokemon VALUES ($randomSpidResult[0],'$randomSpnameResult[0]' , '$rgen', CURRENT_TIMESTAMP, $row[0])");


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
            echo "You caught a " . $randomSpnameResult[0] . "!";

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
                echo "<br> The number of tuples in Pokedex: " . $row[0] . "<br>";
            }

            $resultPm = executePlainSQL("SELECT Count(*) FROM Pokemon ORDER BY OwnedID ASC");
            if (($row = oci_fetch_row($resultPm)) != false) {
                echo "<br> The number of tuples in Your Pokemon Table: " . $row[0] . "<br>";
            }
            OCICommit($db_conn);
        }

        function getElem($elem) {
          global $db_conn;
          $res = executePlainSQL("SELECT S.ID, S.SpName, O.Type1, O.Type2 FROM Species S, ofType O WHERE S.ID=O.ID AND (O.Type1='$elem' OR O.Type2='$elem')");
          while(($row = oci_fetch_row($res)) != false) {
            echo $row[0] . ", " . $row[1] . ", Type: " . $row[2];
            if ($row[3] != NULL) {
              echo " & " . $row[3];
            }
            echo "<br>";
          }
          OCICommit($db_conn);
        }


        function displayPokemon() {
            global $db_conn;

            $res = executePlainSQL("SELECT * FROM Pokemon");
            echo "<table style='border-collapse:separate;border-spacing:20px 0px;'><tr><th>Species ID</th><th>Species</th><th>Gender</th><th>Time Caught</th><th>Owned ID</th></tr>";
            while (($row = oci_fetch_row($res)) != false) {
              echo "<tr><td>". $row[0] . "</td><td>" . $row[1] . "</td><td> " . $row[2] . "</td><td>" . $row[3] . ".</td><td>" . $row[4] . "</td></tr>";
            }
            echo "</table>";
            OCICommit($db_conn);
        }

        function releasePokemon() {
          global $db_conn;

          $rid = $_POST['ridID'];
          if(isset($_POST['ridID']) && is_numeric($rid)) {
            $rpoke = executePlainSQL("SELECT Nickname, OwnedID FROM Pokemon WHERE OwnedID='" . $rid . "'");
            if(($row = oci_fetch_row($rpoke)) != false) {
              $res = executePlainSQL("DELETE FROM Pokemon WHERE OwnedID=$row[1]");
              echo $row[0] . " was released.";
            }
          } else {
            echo "No OwnedID was selected or improper input. No pokemon was released.";
          }

          OCICommit($db_conn);
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
            } else if (array_key_exists('releasePokemonRequest', $_POST)) {
                releasePokemon();
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
            } else if (array_key_exists('getNormal', $_GET)) {
                getElem("Normal");
            } else if (array_key_exists('getGrass', $_GET)) {
                getElem("Grass");
            } else if (array_key_exists('getFire', $_GET)) {
                getElem("Fire");
            } else if (array_key_exists('getWater', $_GET)) {
               getElem("Water");
            } else if (array_key_exists('getGround', $_GET)) {
              getElem("Ground");
            } else if (array_key_exists('getFlying', $_GET)) {
              getElem("Flying");
            } else if (array_key_exists('getPoison', $_GET)) {
              getElem("Poison");
            } else if (array_key_exists('getFighting', $_GET)) {
              getElem("Fighting");
            } else if (array_key_exists('getBug', $_GET)) {
              getElem("Bug");
            } else if (array_key_exists('getElectric', $_GET)) {
              getElem("Electric");
            } else if (array_key_exists('getPsychic', $_GET)) {
              getElem("Psychic");
            } else if (array_key_exists('getFairy', $_GET)) {
              getElem("Fairy");
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])|| isset($_POST['releaseSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['showTupleRequest']) || isset($_GET['displayPokemonRequest'])) {
        handleGETRequest();
    } else if (isset($_GET['getNormalPokemon']) || isset($_GET['getGrassPokemon']) || isset($_GET['getFirePokemon']) || isset($_GET['getWaterPokemon']) || isset($_GET['getGroundPokemon']) || isset($_GET['getFlyingPokemon']) ||
      isset($_GET['getPoisonPokemon']) || isset($_GET['getFightingPokemon']) || isset($_GET['getBugPokemon']) || isset($_GET['getElectricPokemon']) || isset($_GET['getPsychicPokemon']) || isset($_GET['getFairyPokemon'])) {
        handleGETRequest();
    }
		?>
  </div>
	</body>
  <footer>
    <div style="text-align:center;">Created by Derrick Sutanto, Shawn Pak, and Kristen Foong &#169; 2020</div>
  </footer>
</html>
