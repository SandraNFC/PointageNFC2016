<?php

/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 13/04/2016
 * Time: 12:05
 */
include_once('modele/Promotion.php');
class PromotionService
{
    // insert

    public static function insertPromotion(Promotion $promo)
    {
        //echo '++++++++++++++++++++++++++++++ Nom promo dans addpromotion '.$promo->getNomPromotion();
        try{
            $promo->insertToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find

    /**
     * @param Promotion $promo
     * @param $col
     * @param $apresWhere
     * @return array
     */
    public static function findPromotion(Promotion $promo, $col, $apresWhere)
    {
        //echo '___________________________________'.$promo->getIdPromotion();
        try{
            $retPromo = $promo->searchToTable($col,$apresWhere);
            return $retPromo;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // update
    public static function updatePromotion(Promotion $promotion,$col)
    {
        echo '</br> ___________________________________'.$promotion->getIdPromotion();
        echo '</br> ___________________________________'.$promotion->getNomPromotion();
        try{
            $promotion->updateToTable($col);
        }
        catch(Exception $ex)
        {
            $ex->getMessage();
        }
    }

    // delete
    public static function deletePromotion(Promotion $promotion)
    {
        try{
            $promotion->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }
}