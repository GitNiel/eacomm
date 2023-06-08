<?php
    class Record_model {
        private $db;
        public function __construct() {
            $this->db = new Database;
        }

        public function addRecord($data) {

            $this->db->query('INSERT INTO record (product_name, unit, price, date_of_expiry, available_inventory, image) VALUES (:product_name, :unit, :price, :date_of_expiry, :available_inventory, :image)');
            $this->db->bind(':product_name', $data->product_name);
            $this->db->bind(':unit', $data->unit);
            $this->db->bind(':price', $data->price);
            $this->db->bind(':date_of_expiry', $data->date_of_expiry);
            $this->db->bind(':available_inventory', $data->available_inventory);
            $this->db->bind(':image', $data->image);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }   
        }
        
        public function getRecord() {
            $this->db->query('SELECT * FROM record');
            $row = $this->db->resultSet();
            if($row > 0){
                return $row;
            }
        }

        public function getRecordById($id) {
            $this->db->query('SELECT * FROM record WHERE id = (:id)');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            if($this->db->rowCount() > 0) {
                return $row;
            } else {
                return false;
            }
        }

        public function updateRecord($data) {
            if ($data->image != null) {

                $this->db->query('UPDATE record SET product_name = :product_name, unit=:unit, price=:price, date_of_expiry=:date_of_expiry, available_inventory=:available_inventory, image = :image WHERE id = :id');

                $this->db->bind(':product_name', $data->product_name);
                $this->db->bind(':unit', $data->unit);
                $this->db->bind(':price', $data->price);
                $this->db->bind(':date_of_expiry', $data->date_of_expiry);
                $this->db->bind(':available_inventory', $data->available_inventory);
                $this->db->bind(':image', $data->image);
                $this->db->bind(':id', $data->id);

            } else if ($data->image == null) {

                $this->db->query('UPDATE record SET product_name = :product_name, unit=:unit, price=:price, date_of_expiry=:date_of_expiry, available_inventory=:available_inventory, WHERE id = :id');
                
                $this->db->bind(':product_name', $data->product_name);
                $this->db->bind(':unit', $data->unit);
                $this->db->bind(':price', $data->price);
                $this->db->bind(':date_of_expiry', $data->date_of_expiry);
                $this->db->bind(':available_inventory', $data->available_inventory);
                $this->db->bind(':id', $data->id);
            }
            
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteRecord($id) {
            $this->db->query('SELECT * FROM record WHERE id = (:id)');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            if($this->db->rowCount() > 0 ){
               $img = $row->image;
            }
            else{
                return false;
            }
            if(!empty($img)) {
                if(unlink(IMAGEROOT.$img)){
                    $this->db->query('DELETE FROM record WHERE id = (:id)');
                    $this->db->bind(':id', $id);
    
                    if($this->db->execute()){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            } else {
                $this->db->query('DELETE FROM record WHERE id = (:id)');
                $this->db->bind(':id', $id);

                if($this->db->execute()){
                    return true;
                }
                else{
                    return false;
                }
            }
        }

    }