<?php
require_once __DIR__ . "/../dao/category_dao.php";

class category_service
{
    private category_dao $dao;

    public function __construct(string $filePath)
    {
        $this->dao = new category_dao($filePath);
    }

    public function get_all_service(): array
    {
        $categories = $this->dao->get_all();
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                "id" => $category->get_id(),
                "name" => $category->get_name(),
            ];
        }

        return $result;
    }

    public function add_service(string $name): array
    {
        return $this->dao->add($name);
    }
}
?>