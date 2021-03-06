<?php
require_once('Db.class.php');

class Work {
    private $con;

    public function __construct() {
        $conn = new Connect();
        $sql = $conn->connector();
        $this->con = $sql;
        date_default_timezone_set("Africa/Johannesburg");

    }

    ///====================   add   methods ============================

    public function add_client($fname, $lname, $email, $cell_number, $home_address, $city, $zip_code, $person, $title, $initials) {
    	$date_created = date("Y-m-d H:i:s");
    	$sql = "INSERT INTO `clients_tb` (`client_fname`, `client_lname`, `client_dateCreated`, `client_email`, `client_cellno`, `client_home_address`, `client_city`, `client_zip_code`, `client_person`, `client_initials`, `client_title`) VALUES (:fname, :lname, :date_created, :email, :cell_number, :home_address, :city, :zip_code, :person, :initials, :title)";
    	try {
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':date_created', $date_created);
    		$stmt->bindParam(':email', $email);
    		$stmt->bindParam(':cell_number', $cell_number);
            $stmt->bindParam(':home_address', $home_address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':zip_code', $zip_code);
            $stmt->bindParam(':person', $person);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':initials', $initials);

    		if($stmt->execute()) {
                $client = $this->get_clients();
                $lastClient = $client[0];
                $id = $lastClient['client_id'];
                echo json_encode(array(
                    'success' => true,
                    'id'      => $id
                ));
                $this->con = null;
    		}
    	} catch (PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function add_juristic($client_id, $company_name, $registration_number, $registration_date) {
    	try {
            $sql = "INSERT INTO `juristic_tb` (`fk_client_id`, `j_logo`, `j_company_name`, `j_registration_number`, `j_registration_date`) VALUES (:client_id, NULL, :company_name, :registration_number, :registration_date)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':client_id', $client_id);
    		$stmt->bindParam(':company_name', $company_name);
    		$stmt->bindParam(':registration_number', $registration_number);
    		$stmt->bindParam(':registration_date', $registration_date);

            if($stmt->execute()) {
                return true;
                $this->con = null;
    		}
    	}catch (PDOException $e)
    	{
    		echo "Error: ". $e->getMessage();
    	}
    }

    public function add_natural($client_id, $fname, $lname, $mname, $dob, $id_number, $marital_status, $marriage_type) {
    	try {
            $sql = "INSERT INTO `natural_tb` (`fk_client_id`, `n_fname`, `n_lname`, `n_dob`, `n_id_number`, `n_marital_status`, `n_marriage_type`, `n_middle_name`) VALUES (:client_id, :fname, :lname, :dob, :id_number, :marital_status, :marriage_type, :mname)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':client_id', $client_id);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':mname', $mname);
    		$stmt->bindParam(':dob', $dob);
    		$stmt->bindParam(':id_number', $id_number);
    		$stmt->bindParam(':marital_status', $marital_status);
            $stmt->bindParam(':marriage_type', $marriage_type);
            
            if($stmt->execute()) {
                return true;
                $this->con = null;
    		}

    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function add_company_member($j_id, $fname, $lname, $title, $id_number, $date_of_appointment) {
    	try {
            $sql = "INSERT INTO `company_member_tb` (`fk_j_id`, `cm_title`, `cm_fname`, `cm_lname`, `cm_id_number`, `cm_date_of_appointment`) VALUES (:j_id, :title, :fname, :lname, :id_number, :date_of_appointment)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':title', $title);
    		$stmt->bindParam(':id_number', $id_number);
    		$stmt->bindParam(':j_id', $j_id);
    		$stmt->bindParam(':date_of_appointment', $date_of_appointment);

    		if($stmt->execute()) {
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function add_share_holder($j_id, $fname, $lname, $title, $id_number, $amount_contributed) {
    	try {
            $sql = "INSERT INTO `share_holders_tb` (`fk_j_id`, `sh_title`, `sh_fname`, `sh_lname`, `sh_id_number`, `sh_amount_contributed`) VALUES (:j_id, :title, :fname, :lname, :id_number, :amount_contributed)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':title', $title);
    		$stmt->bindParam(':id_number', $id_number);
    		$stmt->bindParam(':j_id', $j_id);
    		$stmt->bindParam(':amount_contributed', $amount_contributed);

    		if($stmt->execute()) {
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}

    }


    public function addUpdate($id, $description) {
    	try {
            $date_updated = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `update_tb` (`fk_idea_id`, `update_date`, `update_description`) VALUES (:id, :date_updated, :description)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':id', $id);
    		$stmt->bindParam(':description', $description);
    		$stmt->bindParam(':date_updated', $date_updated);

            return true;
            $this->con = null;
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }


    public function addDocument($id, $description, $filename, $size, $extension) {
    	try {
            $date_added = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `documents_tb` (`fk_client_id`, `document_name`,  `document_description`, `document_type`, `document_size`, `document_date`) VALUES (:id, :filename, :description, :extension, :size, :date_added)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':id', $id);
    		$stmt->bindParam(':description', $description);
    		$stmt->bindParam(':filename', $filename);
    		$stmt->bindParam(':size', $size);
    		$stmt->bindParam(':extension', $extension);
            $stmt->bindParam(':date_added', $date_added);
            
    		if($stmt->execute()){
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }


    public function add_idea($client_id, $idea_name, $idea_trademark, $idea_nature, $idea_target_market, $sector) {
    	try {

            $date_n = date("y");
            $code = $this->get_idea_code();
            $sql = "INSERT INTO `idea_tb` (`fk_client_id`, `idea_name`, `idea_trademark`, `idea_nature`, `idea_target_market`, `idea_code`, `idea_sector`) VALUES (:client_id, :idea_name, :idea_trademark, :idea_nature, :idea_target_market, :code, :sector)";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':client_id', $client_id);
    		$stmt->bindParam(':idea_name', $idea_name);
    		$stmt->bindParam(':idea_trademark', $idea_trademark);
    		$stmt->bindParam(':idea_nature', $idea_nature);
    		$stmt->bindParam(':idea_target_market', $idea_target_market);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':sector', $sector);
            $client = $this->get_client($client_id);

    		if($stmt->execute()) {
                $this->sendEmail($client, $idea_name, $code);
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error".$e->getMessage();
    	}
    }

    public function add_civil($natural_id, $spouse_fname, $spouse_lname, $spouse_id_number, $certificate_no, $date_of_issue, $marriage_terms, $detail_of_marriage) {
        try {
            $sql = "INSERT INTO `civil_tb` (`fk_n_id`, `c_spouse_fname`, `c_spouse_lname`, `c_id_number`, `c_detail_of_marriage`, `c_certificate_number`, `c_date_of_issue`, `c_marriage_terms`) VALUES (:natural_id, :spouse_fname, :spouse_lname, :spouse_id_number, :detail_of_marriage, :certificate_no, :date_of_issue, :marriage_terms)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':natural_id', $natural_id);
            $stmt->bindParam(':spouse_fname', $spouse_fname);
            $stmt->bindParam(':spouse_lname', $spouse_lname);
            $stmt->bindParam(':spouse_id_number', $spouse_id_number);
            $stmt->bindParam(':detail_of_marriage', $detail_of_marriage);
            $stmt->bindParam(':certificate_no', $certificate_no);
            $stmt->bindParam(':date_of_issue', $date_of_issue);
            $stmt->bindParam(':marriage_terms', $marriage_terms);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function add_customary_spouse($id, $fname, $lname, $id_number, $stages_of_negotiation) {
        try {
            $sql = "INSERT INTO `customary_spouse_tb` (`cs_fk_n_id`, `cs_fname`, `cs_lname`, `cs_id_number`, `cs_stages_of_negotiation`) VALUES (:id, :fname, :lname, :id_number, :stages_of_negotiation)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);
            $stmt->bindParam(':stages_of_negotiation', $stages_of_negotiation);

            if($stmt->execute())
            {
                return true;
                $this->con = null;;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function add_beneficiary($id, $fname, $lname, $id_number) {
        $date_added = date("Y-m-d H:i:s");
        try {
            $sql = "INSERT INTO `beneficiary_tb` (`fk_client_id`, `b_fname`, `b_lname`, `b_id_number`, `b_date_added`) VALUES (:id, :fname, :lname, :id_number, :date_added)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);
            $stmt->bindParam(':date_added', $date_added);

            $client = $this->get_client($id);

            if($stmt->execute()) {
               return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function add_customary_deligation($id, $fname, $lname, $id_number) {
        try {
            $sql = "INSERT INTO `deligation_tb` (`d_fk_cs_id`, `d_fname`, `d_lname`, `d_id_number`) VALUES (:id, :fname, :lname, :id_number)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    ///====================   edit   methods ============================

    public function edit_civil($c_id, $spouse_fname, $spouse_lname, $spouse_id_number, $certificate_no, $date_of_issue, $marriage_terms, $detail_of_marriage) {
        try {
            $sql = "UPDATE `civil_tb` SET `c_spouse_fname`= :spouse_fname , `c_spouse_lname`=:spouse_lname, `c_id_number` =:spouse_id_number, `c_detail_of_marriage` =:detail_of_marriage, `c_certificate_number` =:certificate_no, `c_date_of_issue` =:date_of_issue, `c_marriage_terms` =:marriage_terms WHERE c_id =:c_id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':c_id', $c_id);
            $stmt->bindParam(':spouse_fname', $spouse_fname);
            $stmt->bindParam(':spouse_lname', $spouse_lname);
            $stmt->bindParam(':spouse_id_number', $spouse_id_number);
            $stmt->bindParam(':detail_of_marriage', $detail_of_marriage);
            $stmt->bindParam(':certificate_no', $certificate_no);
            $stmt->bindParam(':date_of_issue', $date_of_issue);
            $stmt->bindParam(':marriage_terms', $marriage_terms);

            if($stmt->execute())
            {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function edit_company_member($cm_id, $fname, $lname, $title, $id_number, $date_of_appointment) {
    	try {
            $sql = "UPDATE `company_member_tb` SET `cm_title`=:title, `cm_fname`=:fname, `cm_lname`=:lname,`cm_id_number`=:id_number, `cm_date_of_appointment`=:date_of_appointment WHERE `cm_id`=:cm_id";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':title', $title);
    		$stmt->bindParam(':id_number', $id_number);
    		$stmt->bindParam(':cm_id', $cm_id);
    		$stmt->bindParam(':date_of_appointment', $date_of_appointment);

    		if($stmt->execute()) {
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function edit_share_holder($sh_id, $fname, $lname, $title, $id_number, $amount_contributed) {
    	try {
            $sql = "UPDATE `share_holders_tb` SET `sh_title`=:title, `sh_fname`=:fname, `sh_lname`=:lname, `sh_id_number`=:id_number, `sh_amount_contributed`=:amount_contributed WHERE `sh_id`=:sh_id";
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':title', $title);
    		$stmt->bindParam(':id_number', $id_number);
    		$stmt->bindParam(':sh_id', $sh_id);
    		$stmt->bindParam(':amount_contributed', $amount_contributed);

    		if($stmt->execute()) {
                return true;
                $this->con = null;
    		}
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}

    }

    public function edit_client($id ,$fname, $lname, $email, $cell_number, $home_address, $zip_code, $city, $title, $initials) {
    	try {
            $sql = "UPDATE `clients_tb` SET`client_fname`=:fname, `client_lname`=:lname, `client_email`=:email, `client_cellno`=:cell_number, `client_home_address`=:home_address, `client_city`=:city, `client_zip_code`=:zip_code, `client_initials`=:initials, `client_title`=:title  WHERE `client_id`=:id";
            $row = $this->get_client($id);
    		$stmt = $this->con->prepare($sql);
    		$stmt->bindParam(':fname', $fname);
    		$stmt->bindParam(':lname', $lname);
    		$stmt->bindParam(':email', $email);
    		$stmt->bindParam(':cell_number', $cell_number);
    		$stmt->bindParam(':id', $id);
            $stmt->bindParam(':home_address', $home_address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':zip_code', $zip_code);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':initials', $initials);

    		if($stmt->execute()) {
                return true;
                $this->con = null;
    		}

    	} catch (PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function verify_doc($document_id) {
        try {
            $status = 1;
            $stmt = $this->con->prepare("UPDATE `documents_tb` SET `document_status`=:status WHERE `document_id`=:document_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':document_id', $document_id);
            $doc = $this->getDocument($document_id);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function edit_juristic($j_id, $company_name, $registration_number, $registration_date) {
        try {
            $sql = "UPDATE `juristic_tb` SET `j_company_name`=:company_name, `j_registration_number`=:registration_number, `j_registration_date`=:registration_date WHERE j_id=:j_id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':company_name', $company_name);
            $stmt->bindParam(':registration_date', $registration_date);
            $stmt->bindParam(':registration_number', $registration_number);
            $stmt->bindParam(':j_id', $j_id);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function edit_beneficiary($id, $fname, $lname, $id_number) {
        try {
            $sql = "UPDATE `beneficiary_tb` SET `b_fname`=:fname, `b_lname`=:lname, `b_id_number`=:id_number WHERE `b_id`=:id";
            $ben = $this->get_beneficiary($id);
            $client = $this->get_client($ben['fk_client_id']);
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }


        }catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function edit_natural($n_id, $mname, $dob, $id_number, $marital_status, $marriage_type) {
        try {
            $sql = "UPDATE `natural_tb` SET `n_middle_name`=:mname, `n_dob`=:dob, `n_id_number`=:id_number, `n_marital_status`=:marital_status, `n_marriage_type`=:marriage_type WHERE `n_id`=:n_id";
            $natural = $this->get_natur($n_id);
            $client = $this->get_client($natural['fk_client_id']);
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':mname', $mname);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':id_number', $id_number);
            $stmt->bindParam(':marriage_type', $marriage_type);
            $stmt->bindParam(':marital_status', $marital_status);
            $stmt->bindParam(':n_id', $n_id);

            if($stmt->execute()) {
                return true;
            }

        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }


    public function edit_idea($id, $idea_name, $idea_trademark, $idea_nature, $idea_target_market, $sector) {
        try {
            $idea = $this->get_idea($id);
            $client = $this->get_client($idea['fk_client_id']);
            $sql = "UPDATE `idea_tb` SET `idea_name`=:idea_name, `idea_trademark`=:idea_trademark, `idea_target_market`=:idea_target_market, `idea_sector`=:sector, `idea_nature`=:idea_nature WHERE `idea_id`=:id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':idea_name', $idea_name);
            $stmt->bindParam(':idea_target_market', $idea_target_market);
            $stmt->bindParam(':idea_trademark', $idea_trademark);
            $stmt->bindParam(':idea_nature', $idea_nature);
            $stmt->bindParam(':sector', $sector);
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                return true;
                $this->con = null;
            }


        }catch(PDOException $e) {
            echo "Error".$e->getMessage();
        }
    }

    public function edit_customary_spouse($id, $fname, $lname, $id_number, $stages_of_negotiation) {
        try {
            $sql = "UPDATE `customary_spouse_tb` SET `cs_fname`=:fname, `cs_lname`=:lname, `cs_id_number`=:id_number, `cs_stages_of_negotiation`=:stages_of_negotiation WHERE `cs_id`=:id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);
            $stmt->bindParam(':stages_of_negotiation', $stages_of_negotiation);
            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function editDeligation($id, $fname, $lname, $id_number) {
        try {
            $sql = "UPDATE `deligation_tb` SET `d_fname`=:fname, `d_lname`=:lname, `d_id_number`=:id_number WHERE `d_id`=:id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id_number', $id_number);
            if($stmt->execute()) {
                return true;
                $this->con = null;
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }      
    }


    ///====================   view   methods ============================

    public function get_clients() {
    	$stmt = $this->con->query("SELECT * FROM `clients_tb` ORDER BY `client_dateCreated` DESC");
    	$clients = array();
    	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    		$clients[] = $row;
    	}
    	return $clients;
    	$this->con=null;
    }

    public function get_client($id) {
        $stmt = $this->con->query("SELECT * FROM clients_tb WHERE client_id='$id'");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getClients($dateFilter, $person, $type) {
        try {
            $sql = null;
            
            $j_select = "SELECT * FROM `clients_tb` LEFT JOIN `juristic_tb` ON 
                        `clients_tb`.`client_id`= `juristic_tb`.`fk_client_id` WHERE 
                        `clients_tb`.`client_person` = '$person' ORDER BY `client_dateCreated` DESC";

            $n_select = "SELECT * FROM `clients_tb` LEFT JOIN `natural_tb` ON
                        `clients_tb`.`client_id`= `natural_tb`.`fk_client_id` WHERE 
                        `clients_tb`.`client_person` = '$person' ORDER BY `client_dateCreated` DESC";
            switch($type) {
                case "person":
                    if($person == "Juristic") {
                        $sql = $j_select;
                    }else if($person == "Natural") {
                        $sql = $n_select;
                    }
                break;

                case "month":
                    $myDate = explode('-', $dateFilter);
                    $y = $myDate[0];
                    $m = $myDate[1];

                    $selector = "MONTH(`clients_tb`.`client_dateCreated`) = '$m' AND
                                 YEAR(`clients_tb`.`client_dateCreated`) = '$y'";
                    if($person == "Juristic") {
                        $sql = $j_select." AND ".$selector;
                    }else if($person == "Natural") {
                        $sql = $n_select." AND ".$selector;
                    }
                break;
            }

            $stmt = $this->con->query($sql);
            $clientsArray = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['client_id'];
                $objOthers = array(
                    'document_count' => count($this->getDocuments($id)),
                    'idea_count' => count($this->get_ideas($id))
                );
                $clientsArray[] = array_merge($row, $objOthers);
            }
            return $clientsArray;

        } catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getClient($id) {
        try {
            $sql = "SELECT * FROM `clients_tb` WHERE `client_id`='$id'";
            $stmt = $this->con->query($sql);
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                $client = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $client['client_id'];
                $documents = $this->getDocuments($id);
                $ideas = $this->get_ideas($id);

                if($client['client_person'] == "Juristic") {
                    $juristic = $this->get_juristic($id);
                    if($juristic !== null) {
                        $company_members = $this->getCompany_members($juristic['j_id']);
                        $share_holders = $this->getShare_holders($juristic['j_id']);
                        echo json_encode(array(
                            'client'          => $client, 
                            'juristic'        => $juristic,
                            'company_members' => $company_members,
                            'share_holders'   => $share_holders,
                            'documents'       => $documents,
                            'ideas'           => $ideas
                        ));
                    } else {
                        echo json_encode(array(
                            'client'   => $client,
                            'juristic' => $juristic
                        ));
                    }


                }else if($client['client_person'] == "Natural") {
                    $natural = $this->get_natural($id);
                    if($natural !== null) {
                        if($natural['n_marital_status'] == "Single") {
                            $beneficiaries = $this->get_beneficiaries($id);
                            echo json_encode(array(
                                'client'        => $client,
                                'natural'       => $natural,
                                'beneficiaries' => $beneficiaries,
                                'documents'     => $documents,
                                'ideas'         => $ideas
                            ));
                        }else if($natural['n_marital_status'] == "Married") {
                            if($natural['n_marriage_type'] == "Civil") {
                                $civil = $this->get_civil($natural['n_id']);
                                echo json_encode(array(
                                    'client'        => $client,
                                    'natural'       => $natural,
                                    'civil'         => $civil,
                                    'documents'     => $documents,
                                    'ideas'         => $ideas
                                ));
                            }else if($natural['n_marriage_type'] == "Customary") {
                                $spouses = $this->get_spouses($natural['n_id']);
                                echo json_encode(array(
                                    'client'        => $client,
                                    'natural'       => $natural,
                                    'spouses'        => $spouses,
                                    'documents'     => $documents,
                                    'ideas'         => $ideas
                                ));
                            }
                        }
                    }else {
                        echo json_encode(array(
                            'client'        => $client,
                            'natural'       => $natural
                        ));
                    }
                }
            }
        } catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }

    }

    public function get_natural($id) {
        $stmt = $this->con->query("SELECT * FROM natural_tb WHERE fk_client_id=$id");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    	
    }

    public function get_natur($id) {
        $stmt = $this->con->query("SELECT * FROM natural_tb WHERE n_id=$id");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    	
    }

    public function get_juristic($id) {
        $stmt = $this->con->query("SELECT * FROM juristic_tb WHERE fk_client_id=$id");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    	
    }

    public function get_juri($id) {
        $stmt = $this->con->query("SELECT * FROM juristic_tb WHERE j_id=$id");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    	
    }

    public function getDirector($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `company_member_tb` WHERE `cm_id` = '$id'");
            if($stmt->rowCount() == 0) {
                echo json_encode(array(
                    'success' => false
                ));
            } else {
                $director = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'success'  => true,
                    'director' => $director
                ));               
            }
        }catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getShareHolder($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `share_holders_tb` WHERE `sh_id` = '$id'");
            if($stmt->rowCount() == 0) {
                echo json_encode(array(
                    'success' => false
                ));
            } else {
                $holder = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'success'  => true,
                    'holder' => $holder
                ));               
            }
        }catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getIdea($id) {
        try {
            $sql = "SELECT * FROM `idea_tb` WHERE idea_id=$id";
            $stmt = $this->con->query($sql);
            if($stmt->rowCount() == 0) {
                echo json_encode(array(
                    'success'   => false
                ));
            }else {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'success'   => true,
                    'idea'      => $row
                ));
            }
            
            $this->con = null;

        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }  
    }

    public function getCompany_members($j_id) {
        try {
            $sql = "SELECT * FROM `company_member_tb` WHERE `fk_j_id` = $j_id";
            $stmt = $this->con->query($sql);
            $result = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            return $result;
        }catch(PDOException $e) {
            echo "Error ".$e->getMessage();
        }
    }

    public function getShare_holders($j_id) {
        try {
        	$sql = "SELECT * FROM `share_holders_tb` WHERE `fk_j_id` = $j_id";
        	$stmt = $this->con->query($sql);
        	$result = array();

        	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        		$result[] = $row;
        	}

        	return $result;
        }catch(PDOException $e) {
           echo "Error ".$e->getMessage();
        }
    }

    public function getDocuments($id) {
    	$sql = "SELECT * FROM `documents_tb` WHERE fk_client_id=$id ORDER BY document_date DESC";
    	try {
    		$stmt = $this->con->query($sql);
    		$result = array();
    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    			$result[] = $row;
    		}
    		return $result;
    	}catch(PDOException $e) {
    		echo "Error: ".$e->getMessage();
    	}
    }

    public function getDocument($id)
    {
        try {
            $stmt = $this->con->query("SELECT * FROM `documents_tb` WHERE document_id=$id");
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }       
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }


    public function get_ideas($id) {
        try {
            $sql = "SELECT * FROM `idea_tb` WHERE fk_client_id=$id ORDER BY `idea_date` DESC";
            $stmt = $this->con->query($sql);
            $result = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            return $result;
            $this->con = null;
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_idea($id) {
        try {
            $sql = "SELECT * FROM `idea_tb` WHERE idea_id=$id";
            $stmt = $this->con->query($sql);
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            $this->con = null;

        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_civil($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `civil_tb` WHERE `fk_n_id`=$id");
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getDeligations($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `deligation_tb` WHERE `d_fk_cs_id`=$id");
            $res = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }
            return $res;
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getDeligation($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `deligation_tb` WHERE `d_id`=$id");
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_spouses($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `customary_spouse_tb` WHERE `cs_fk_n_id`=$id");
            $res = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }
            return $res;
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_spouse($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `customary_spouse_tb` WHERE `cs_fk_n_id`=$id");
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            

        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getSpouse($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `customary_spouse_tb` WHERE `cs_id`=$id");
            if($stmt->rowCount() == 0) {
                echo json_encode(array(
                    'success' => false
                ));
            }else {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $fname = $row['cs_fname'];
                $lname = $row['cs_lname'];
                $id_number = $row['cs_id_number'];
                $stages = $row['cs_stages_of_negotiation'];

                echo json_encode(array(
                    'success' => true,
                    'fname' => $fname,
                    'lname' => $lname,
                    'id_number' => $id_number,
                    'stages' => $stages
                ));
            }

        }catch(PDOException $e)
        {
            echo "Error: ".$e->getMessage();
        }      
    }

    public function get_idea_code() {
        $date_now = date('Y');
        $code = "";
        $stmt = $this->con->query("SELECT * FROM `idea_tb` WHERE YEAR(`idea_date`) = $date_now");
        $res = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        if(sizeof($res) >= 0 && sizeof($res) <= 9) {
            $code = "KU".date("y")."000".sizeof($res);
        }

        if(sizeof($res) >= 10 && sizeof($res) <= 99) {
            $code = "KU".date("y")."00".sizeof($res);
        }

        if(sizeof($res) >= 100 && sizeof($res) <= 999) {
            $code = "KU".date("y")."0".sizeof($res);
        }

        if(sizeof($res) >= 1000 && sizeof($res) <= 9999) {
            $code = "KU".date("y").sizeof($res);
        }
        return $code;
    }



    public function sendEmail($client, $idea_name, $code) {
        require '../phpmailer/PHPMailerAutoload.php';
        $to = $client['client_email']; // this is your Email address
        $from = 'info@kunokhar.com'; // this is the sender's Email address
        $mail = new PHPMailer;
        //$mail->isSMTP();
        $mail->Host = gethostname();//'mail.kunokhar.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = $from;
        $mail->Password = '!nf0@kuN0kh@r';
        $mail->setFrom($from, 'Kunokhar Ctp');
        $mail->addAddress($to);
        $mail->addReplyTo($from);
        $mail->isHTML(true);
        $mail->Subject = 'Idea registration at Kunokhar CTP';
        $msg = '<h5>Dear '.$client['client_title']. " ".$client['client_initials'] .". ".$client['client_lname'].',<br><br>
                Thank you for registering your idea with us('.$idea_name.').<br>
                Double check if you have provided a correct information before leaving the office,<br>
                If there is any error you encounter later than after you have left you\'ll have to pay<br>
                some amount. Below is your idea code which you can use to for rectifying your details and update them,<br>
                reprinting your certificiate in case you lose it. For reprinting there is a fee.
                </h5>
                <h1>'.$code.'</h1>
                <h5>
                Thank you again for working with us.<br>
                Have a good day<br><br>
                Kunokhar CTP
                </h5>
                ';
        $mail->Body = $msg;
        if($mail->send()) {
            return true;
        }
    }

    public function getUser($id) {
        $stmt = $this->con->query("SELECT * FROM workers_tb WHERE w_id=$id");
        if($stmt->rowCount() == 0) {
            return null;
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    	
    }

    public function get_logs($id) {
        try {
            $sql = "SELECT log_report, log_date, w_fname, w_lfname, w_id, fk_w_id FROM `log_tb`, `workers_tb` WHERE `log_tb`.`fk_w_id`=`workers_tb`.$id";
            $stmt = $this->con->query($sql);
            $res = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }

            return $res;
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_beneficiaries($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `beneficiary_tb` WHERE fk_client_id=$id");
            $res = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }
            return $res;
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function get_beneficiary($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `beneficiary_tb` WHERE b_id=$id");
            if($stmt->rowCount() == 0) {
                return null;
            }else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }       
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function getBeneficiary($id) {
        try {
            $stmt = $this->con->query("SELECT * FROM `beneficiary_tb` WHERE b_id=$id");
            if($stmt->rowCount() == 0) {
                echo json_encode(array(
                    'success' => false
                ));
            }else {
                $beneficiary = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'success'     => true,
                    'beneficiary' => $beneficiary
                ));
            }       
        }catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }  
    }

    ///====================   Delete   methods ============================

    public function delete_member($cm_id) {
    	if($this->con->exec("DELETE FROM `company_member_tb` WHERE cm_id = $cm_id")) {
    		return true;
    		$this->con = null;
    	}
    }

    public function delete_holder($sh_id) {
    	if($this->con->exec("DELETE FROM `share_holders_tb` WHERE sh_id = $sh_id")) {
    		return true;
    		$this->con = null;
    	}
    }

    public function delete_beneficiary($b_id) {
        if($this->con->exec("DELETE FROM `beneficiary_tb` WHERE b_id = $b_id")) {
            return true;
            $this->con = null;
        }
    }

    public function delete_customary_spouse($id) {
      if($this->con->exec("DELETE FROM `customary_spouse_tb` WHERE `cs_id` = $id")) {
          return true;
          $this->con = null;
      }
    }

    public function deleteDeligation($id) {
        if($this->con->exec("DELETE FROM `deligation_tb` WHERE `d_id` = $id")) {
            return true;
            $this->con = null;
        }
      }

    public function deleteDoc($id) {
        $doc = $this->getDocument($id);
        if($this->con->exec("DELETE FROM `documents_tb` WHERE `document_id` = $id")) {
            $file = '../public/uploads/'. $doc['document_name'];
            if(file_exists($file)) {
                unlink($file);
            }
            return true;
            $this->con = null;
        }       
    }

}
