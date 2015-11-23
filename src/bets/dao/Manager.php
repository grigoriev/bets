<?php

namespace bets\dao;

interface Manager
{
    public function create();

    public function findById($id);

    public function findAll();

    public function update($entity);

    public function delete($entity);
}