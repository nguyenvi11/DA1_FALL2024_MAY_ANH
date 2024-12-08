<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $table = 'categories';
    protected $id = 'id';

    public function getAllCategory()
    {
        return $this->getAll();
    }
    public function getOneCategory($id)
    {
        return $this->getOne($id);
    }

    public function createCategory($data)
    {
        return $this->create($data);
    }
    public function updateCategory($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->delete($id);
    }
    public function getAllCategoryByStatus()
    {
        return $this->getAllByStatus();
    }
    
    public function getOneCategoryByName($id)
    {
        return $this->getOneByName($id);
    }
    public function countTotalCategory(){
        return $this->countTotal();
    }
    public function getCategoryNameById($id)
    {
        // Tạo câu truy vấn để lấy tên danh mục từ id
        $sql = "SELECT name FROM categories WHERE id = ? AND status = ?";
        $conn = $this->_conn->MySQLi();
        
        // Chuẩn bị và thực thi câu truy vấn
        $stmt = $conn->prepare($sql);
        $status = self::STATUS_ENABLE;  // Lọc theo trạng thái ENABLE của danh mục
        $stmt->bind_param('ii', $id, $status);
        $stmt->execute();

        // Lấy kết quả và trả về tên danh mục
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        
        // Nếu có kết quả, trả về tên danh mục, nếu không trả về null
        return $category ? $category['name'] : null;
    }
}
