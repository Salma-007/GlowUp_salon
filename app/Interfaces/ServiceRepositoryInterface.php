<?php

namespace App\Interfaces;

interface ServiceRepositoryInterface
{
    public function allWithCategoryAndMonthlyReservations($categoryId = null, $perPage = 5);
    public function searchWithCategoryAndMonthlyReservations($searchTerm);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function find($id);
    public function getCategories();
}