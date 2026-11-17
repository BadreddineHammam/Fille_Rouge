<?php
require_once __DIR__ . "/../class/category.php";

class category_dao
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function get_all(): array
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, "[]", LOCK_EX);
        }

        $json = file_get_contents($this->filePath);

        if ($json === false) {
            throw new RuntimeException("The category file could not be read.");
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new RuntimeException("The category file does not contain valid data.");
        }

        $categories = [];
        foreach ($data as $item) {
            if (!isset($item["id"], $item["name"])) {
                continue;
            }

            $categories[] = new category((int) $item["id"], (string) $item["name"]);
        }

        return $categories;
    }

    public function add(string $name): array
    {
        $categoryName = trim($name);
        if ($categoryName === "") {
            throw new InvalidArgumentException("Please enter a category name.");
        }

        $categories = $this->get_all();
        foreach ($categories as $category) {
            if (strcasecmp($category->get_name(), $categoryName) === 0) {
                throw new InvalidArgumentException("This category already exists.");
            }
        }

        $nextId = 1;
        foreach ($categories as $category) {
            $nextId = max($nextId, $category->get_id() + 1);
        }

        $newCategory = new category($nextId, $categoryName);
        $categories[] = $newCategory;

        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                "id" => $category->get_id(),
                "name" => $category->get_name(),
            ];
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false || file_put_contents($this->filePath, $json . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException("The category could not be saved.");
        }

        return [
            "id" => $newCategory->get_id(),
            "name" => $newCategory->get_name(),
        ];
    }
}
?>