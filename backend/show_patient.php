<?php                                                    # code...
    $dbhost = getenv("DBHOST");
    $dbuser = getenv("DBUSER");
    $dbpass = getenv("DBPASS"); 
    $dbname = getenv("DBNAME");
    $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
                                                        
    mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

    if (isset($_GET['Pat_ID'])) {  
        $Pat_ID = $_GET['Pat_ID'];  
        $query = "DELETE FROM `patient` WHERE Pat_ID = '$Pat_ID'";  
        $run = mysqli_query($link,$query);  
        if ($run) {  
            header('location:/backend/show_patient.php');  
        }else{  
            echo "Error: ".mysqli_error($link);  
        }  
    }

    if (isset($_GET['submit']))
    {
        $ID = $_GET['ID'];
        // $Spec = $_GET['Spec'];
        $FName = $_GET['Fname'];
        // $Mname = $_GET['Mname'];
        $Lname = $_GET['Lname'];
        $Gender = $_GET['gender'];
        // $DOB = $_GET['DOB'];
        // initiallizing as a string this is aproblem cause idk what to do with date types
        $DOB = "";
        $Mname = "";
        

        if ($ID != '' ||$FName != '' ||$Lname != '' ||$Gender != '' )
        {
            // something changed so do this
            $select = "SELECT * FROM patient WHERE Pat_ID = '$ID' or Pat_Gender = '$Gender' or Pat_First = '$FName' or  Pat_Last = '$Lname'  ";
        }else{
            // if nothing set and pressed submit
            $select = "SELECT * FROM patient";
        }
    }else{
        // if nothing set the print all
        $select = "SELECT * FROM patient";
    }

    $query=mysqli_query($link,$select); 
?>    
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/index/styles/show_patients.css">
    <link rel="stylesheet" href="/index/styles/form.css">
</head>

<body>
    <div class="container-form12">  
        <form action = "/backend/show_patient.php" method  = "GET">
        <div class="row">
            <h4>Patient ID</h4>
                <div class="input-group input-group-icon">
                    <input type = "text" placeholder="0000000" name="ID" value = ""/>
                    <div class="input-icon"></div>
                </div>
            <h4>First Name</h4>
                <div class="input-group input-group-icon">
                    <input type = "text" placeholder="First Name" name="Fname" value = ""/>
                    <div class="input-icon"></div>
                </div>
            <h4>Last Name</h4>
                <div class="input-group input-group-icon">
                    <input type = "text" placeholder="Last Name" name="Lname" value = ""/>
                    <div class="input-icon"></div>
                </div>
        </div>
            <div class="row"> 
                <h4 style="float: left;">Gender &#160<h4 style="color: blue;">&nbsp</h4></h4>
                <div class="input-group">
                    <div class="col-third">
                        <input  id="gender-male" type="radio" name="gender" value="Male" required />
                        <label id="width" class="float-right" for="gender-male">Male</label>
                    </div>
                   <div class="col-third">
                        <input  id="gender-female" type="radio" name="gender" value="Female" required />
                        <label id="width" class="float-right" for="gender-female">Female</label>
                   </div>
                    <div class="col-third">
                        <input  id="either" type ="radio" name="gender" value ="" checked = "checked">
                        <label id="width" class="float-right" for="either">Either</label> 
                    </div>
                </div>
            </div>
            <div >
                <!-- <label > Last Name </label> -->
                <div >
                <input class="button2" type='submit' name='submit' value='SEARCH'/> 
                </div>
            </div>   
        </form>
        <div>
        <div class="input-group">
            <form>
            <div class="input-group">
                <div class="col-third">
                    <input class="button2" type="button" value="BACK" onclick="history.back()">      
                </div>
                <div class="col-third">
                    <input class="button2" type="button" onclick="location.href='/index/OA_profile.php?'" value="Profile" />
                </div>
                <div class="col-third">
                    <input class="button2" type="button" onclick="location.href='/index/home.php?'" value="Home" />
                </div> 
            </div>
            </form>
        </div>

        
        </div>
    </div>

    <table border="1" cellpadding="0">
    <tr>
        <th>Patient ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Operation</th>
    </tr>
    <?php 
        $num=mysqli_num_rows($query);
        if ($num>0) {
            while ($result=mysqli_fetch_assoc($query)) {
                echo "
                    <tr>
                        <td>".$result['Pat_ID']."</td>
                        <td>".$result['Pat_First']."</td>
                        <td>".$result['Pat_Last']."</td>
                        <td>".$result['Pat_Phone']."</td>
                        <td>".$result['Pat_Email']."</td>
                        <td>
                            <a href='/backend/edit_patient.php?Pat_ID=".$result['Pat_ID']."'class='btn'>Edit</a>
                            <a href='/backend/show_patient.php?Pat_ID=".$result['Pat_ID']."'class='btn deny'>Delete</a>
                        </td>
            
                    </tr>
                
                ";
            }
        }
    
    ?>
    
    </table>
    

</body>