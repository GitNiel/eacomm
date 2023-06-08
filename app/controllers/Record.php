<?php 

    class Record extends Controller {
        
       
        public function __construct() {

          $this->recordModel = $this->model('Record_model');

        }

        public function index() {
            $this->view('record');
        }

        public function getRecord() {
            $record = $this->recordModel->getRecord();
            echo json_encode($record);
        }

        public function getRecordById($id) {
            $record = $this->recordModel->getRecordById($id);
            echo json_encode($record);
        }

        public function addRecord() {

            $file = $_FILES['product_image'];
            $filename = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $fileExt = explode ('.',$filename);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg','jpeg', 'png', 'pdf','jfif');

            if(in_array($fileActualExt, $allowed)){
                if( $fileError === 0){
                    if($fileSize < 1000000){        
                        $fileNameNew = uniqid('',true).".".$fileActualExt;
                        $target = "uploads/". basename($fileNameNew);
                        move_uploaded_file($fileTmpName, $target);
                        $data['file'] = $fileNameNew;
                    }
                }
            }

            $data = [
                'product_name' => $_POST['product_name'],
                'unit' => $_POST['unit'],
                'price' => $_POST['price'],
                'date_of_expiry' => $_POST['date_of_expiry'],
                'available_inventory' => $_POST['available_inventory'],
                'image' => $fileNameNew,
            ];
            
            $json = json_decode(json_encode($data));

            $isRecordSaved = $this->recordModel->addRecord($json);    

            if($isRecordSaved){

                $response = ['message' => 'Record is successfully submitted', 'isSuccess' => 1];

            } else {
                $response = ['message' => 'Something went wrong. Please try to reload the page', 'isSuccess' => 0];

            }

            echo json_encode($response);
        }

        public function deleteRecord($id) {

            $isRecordDeleted = $this->recordModel->deleteRecord($id);    

            if($isRecordDeleted){

                $response = ['message' => 'Record is successfully deleted', 'isSuccess' => 1];

            } else {
                $response = ['message' => 'Something went wrong. Please try to reload the page', 'isSuccess' => 0];
            }

            echo json_encode($response);
        }

        public function updateRecord() {

            if (isset($_POST['product_image'])){
                $fileNameNew = $_POST['product_image'];
            }
       
            if (isset($_FILES['product_image'])) {
                $file = $_FILES['product_image'];
                $filename = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];
        
                $fileExt = explode ('.',$filename);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg', 'png', 'pdf','jfif');
        
                if(in_array($fileActualExt, $allowed)){
                    if( $fileError === 0){
                        if($fileSize < 1000000){        
                            $fileNameNew = uniqid('',true).".".$fileActualExt;
                            $target = "uploads/". basename($fileNameNew);
                            move_uploaded_file($fileTmpName, $target);
                            $data['image'] = $fileNameNew;
                        }
                    }
                }
            }
       
            $data = [
                'product_name' => $_POST['product_name'],
                'unit' => $_POST['unit'],
                'price' => $_POST['price'],
                'date_of_expiry' => $_POST['date_of_expiry'],
                'available_inventory' => $_POST['available_inventory'],
                'image' => $fileNameNew,
                'id' => $_POST['id'],
            ];
       
            $json = json_decode(json_encode($data));

            $isRecordSaved = $this->recordModel->updateRecord($json);    

            if($isRecordSaved){

                $response = ['message' => 'Record is successfully edited', 'isSuccess' => 1];

            } else {
                $response = ['message' => 'Something went wrong. Please try to reload the page', 'isSuccess' => 0];

            }

            echo json_encode($response);
        }
    }

?>