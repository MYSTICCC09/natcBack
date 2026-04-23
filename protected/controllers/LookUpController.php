<?php

class LookUpController extends RestController {

    public function restEvents() {
        $this->onRest('req.get.vendorList.render', function ($data) {
            $vendorsArr = array();
            $vendors = PosSetupVendor::model()->findAll();
            foreach ($vendors as $key => $vendor) {
                $vendorsArr[$key]['vId'] = $vendor->vendor_id;
                $vendorsArr[$key]['vName'] = $vendor->vendor_alias . "-" . $vendor->vendor_contact_name;
            }
            echo $this->restJsonEncode($vendorsArr);
        });
        $this->onRest('req.get.categoryList.render', function ($data) {
            $catArr = array();
            $categories = PosSetupAttribute::model()->findAll();
            foreach ($categories as $key => $category) {
                $catArr[$key]['cId'] = $category->category_id;
                $catArr[$key]['cName'] = $category->category_name . "-" . $category->category_desc;
            }
            echo $this->restJsonEncode($catArr);
        });
        $this->onRest('req.get.mapBreakdown.render', function () {
            $qty = $_GET['qty'];
            $wbId = $_GET['wbId'];
            if ($wbId != 0) {
                $bd = PosWorksheetBreakdown::model()->findByPk($wbId);
                $mapArr[$qty][5] = $bd->s5;
                $mapArr[$qty][6] = $bd->s6;
                $mapArr[$qty][7] = $bd->s7;
                $mapArr[$qty][8] = $bd->s8;
                $mapArr[$qty][9] = $bd->s9;
                $mapArr[$qty][10] = $bd->s10;
                echo $this->restJsonEncode($mapArr[$qty]);
            } else {
                $mapArr = array();
                $mapArr[0][5] = 0;
                $mapArr[0][6] = 0;
                $mapArr[0][7] = 0;
                $mapArr[0][8] = 0;
                $mapArr[0][9] = 0;
                $mapArr[0][10] = 0;

                $mapArr[3][5] = 0;
                $mapArr[3][6] = 1;
                $mapArr[3][7] = 1;
                $mapArr[3][8] = 1;
                $mapArr[3][9] = 0;
                $mapArr[3][10] = 0;

                $mapArr[6][5] = 1;
                $mapArr[6][6] = 1;
                $mapArr[6][7] = 2;
                $mapArr[6][8] = 1;
                $mapArr[6][9] = 1;
                $mapArr[6][10] = 0;

                $mapArr[8][5] = 1;
                $mapArr[8][6] = 1;
                $mapArr[8][7] = 2;
                $mapArr[8][8] = 2;
                $mapArr[8][9] = 1;
                $mapArr[8][10] = 1;

                $mapArr[10][5] = 1;
                $mapArr[10][6] = 2;
                $mapArr[10][7] = 2;
                $mapArr[10][8] = 2;
                $mapArr[10][9] = 2;
                $mapArr[10][10] = 1;

                $mapArr[12][5] = 1;
                $mapArr[12][6] = 2;
                $mapArr[12][7] = 3;
                $mapArr[12][8] = 3;
                $mapArr[12][9] = 2;
                $mapArr[12][10] = 1;

                $mapArr[14][5] = 2;
                $mapArr[14][6] = 2;
                $mapArr[14][7] = 3;
                $mapArr[14][8] = 3;
                $mapArr[14][9] = 2;
                $mapArr[14][10] = 2;

                $mapArr[16][5] = 2;
                $mapArr[16][6] = 2;
                $mapArr[16][7] = 4;
                $mapArr[16][8] = 4;
                $mapArr[16][9] = 2;
                $mapArr[16][10] = 2;

                $mapArr[18][5] = 2;
                $mapArr[18][6] = 3;
                $mapArr[18][7] = 4;
                $mapArr[18][8] = 4;
                $mapArr[18][9] = 3;
                $mapArr[18][10] = 2;

                $mapArr[24][5] = 2;
                $mapArr[24][6] = 4;
                $mapArr[24][7] = 6;
                $mapArr[24][8] = 6;
                $mapArr[24][9] = 4;
                $mapArr[24][10] = 2;
                echo $this->restJsonEncode($mapArr[$qty]);
            }

            
        });
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
