<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 20/06/15
 * Time: 15:38
 */

class formDataController extends dataController
{
    public function action()
    {

        try{
            //Preparing the Statement
            $StoredProcedure = $this->db->prepare("CALL FormDataInsert( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                                                                        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $paramCount = 1;
            //Bind The table Name

            new Log("Table Name: " . $this->table );
            $StoredProcedure->bindValue($paramCount++, $this->table, PDO::PARAM_STR);


            //Binding the inputted data
            foreach($this->inputData as $key => $value)
            {
                new Log("column Name : " . $key );
                new Log("Value Name : " . $value );
                $StoredProcedure->bindValue($paramCount++, $key, PDO::PARAM_STR);
                $StoredProcedure->bindValue($paramCount++, $value, PDO::PARAM_STR);
            }

            //binding the rest.
            for($paramCount; $paramCount < 42; $paramCount++)
            {
                $StoredProcedure->bindValue($paramCount, " ", PDO::PARAM_STR);
            }

            $StoredProcedure->execute();

        }catch(PDOException $e)
        {
            new Log("error  " . $e->getMessage() );
            new ErrorLog("Unable to execute FormDataInsertProcedure : " . $e->getMessage());
        }
    }
}