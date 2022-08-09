<?php

function MakeInsertQuery($table, $data)
{
    $where = implode(",", array_keys($data));
    $val = implode(",", array_map(function ($val) {
        return "'" . $val . "'";
    }, array_values($data)));

    $query = "INSERT INTO " . $table . " (" . $where . ") " . " VALUES (" . $val . ")";

    return $query;
}

function MakeEditQuery($table, $data, $where)
{
    $set = ConditionToQ($data, ",");

    $query = "UPDATE " . $table . " SET " . $set . " " . $where;

    return $query;
}

function MakeSearchQuery($table, $search, $into, $where)
{
    $w = isset($where) ? ConditionToQ($where, " AND ") : "";
    $sf = array_fill(0, count($into), $search);
    $wf = array_fill(0, count($into), $w);
    $likes = implode(" OR ", array_map(function ($i, $j, $k) {
        return $i . " LIKE " . "'{$j}%' " . (!empty($k) ? " AND " . $k : "");
    }, $into, $sf, $wf));

    $query = "SELECT * FROM " . $table . "  WHERE " . $likes;

    return $query;
}

function ConditionToQ($data, $delimeter)
{
    return implode($delimeter, array_map(function ($value, $key) {
        return $key . "=" . "'" . $value . "'";
    }, $data, array_keys($data)));
}

function Select($table, $where, $fetchAll, $database)
{
    $w = isset($where) ? " WHERE " . ConditionToQ($where, " AND ") : "";
    $query = "SELECT * FROM " . $table . $w;
    $stmt = $database->prepare($query);
    $stmt->execute();

    if ($fetchAll) {
        return $stmt->fetchAll();
    }
    else {
        return $stmt->fetch();
    }
}

function CountRow($table, $where, $database)
{
    $w = isset($where) ? " WHERE " . ConditionToQ($where, " AND ") : "";
    $query = "SELECT * FROM " . $table . $w;
    $stmt = $database->prepare($query);
    $stmt->execute();
    return $stmt->rowCount();
}

function Delete($table, $where, $database)
{
    $w = isset($where) ? " WHERE " . ConditionToQ($where, " AND ") : "";
    $query = "DELETE FROM " . $table . $w;
    $stmt = $database->prepare($query);
    return $stmt->execute();
}

function Update($table, $data, $where, $database)
{
    $w = isset($where) ? " WHERE " . ConditionToQ($where, " AND ") : "";
    $query = MakeEditQuery($table, $data, $w);
    $stmt = $database->prepare($query);
    return $stmt->execute();
}

function SelectBetween($table, $column, $from, $to, $database)
{
    $query = "SELECT * FROM $table WHERE $column BETWEEN '$from' AND '$to'";
    $stmt = $database->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function Insert($table, $data, $database, $getID = false)
{
    $query = MakeInsertQuery($table, $data);
    $stmt = $database->prepare($query);

    if ($stmt->execute()) {
        if ($getID) {
            return $database->lastInsertId();
        }

        return true;
    }


    return false;
}

function Search($table, $search, $into, $where, $database)
{
    $query = MakeSearchQuery($table, $search, $into, $where);
    $stmt = $database->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}