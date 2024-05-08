<?php

class ProductRepository extends BaseRepository
{
    protected function fetchAll($condition = null, $sort = null, $limit = null)
    {
        global $conn;
        $products = array();

        $sql = "SELECT * FROM product";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        if ($sort) {
            $sql .= " $sort";
        }

        if ($limit) {
            $sql .= " $limit";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product(
                    $row["id"],
                    $row["discount_id"],
                    $row["name"],
                    $row["price"],
                    $row["featured_image"],
                    $row["inventory_qty"],
                    $row["category_id"],
                    $row["brand_id"],
                    $row["created_date"],
                    $row["description"],
                    $row["enter_price"],
                    $row["deleted"],
                    $row["updated_at"],
                    $row["featured"]
                );
                $products[] = $product;
            }
        }

        return $products;
    }

    // Get all products
    function getAll()
    {
        return $this->getBy();
    }

    // Get products based on conditions and sorting
    function getBy($array_conds = array(), $array_sorts = array(), $page = null, $qty_per_page = null)
    {
        if ($page) {
            $page_index = $page - 1;
        }

        $temp = array();
        foreach ($array_conds as $column => $cond) {
            $type = $cond['type'];
            $val = $cond['val'];
            $str = "$column $type ";
            if (in_array($type, array("BETWEEN", "LIKE"))) {
                $str .= "$val";
            } else {
                $str .= "'$val'";
            }
            $temp[] = $str;
        }
        $condition = null;

        if (count($array_conds)) {
            $condition = implode(" AND ", $temp);
        }

        $temp = array();
        foreach ($array_sorts as $key => $sort) {
            $temp[] = "$key $sort";
        }
        $sort = null;

        if (count($array_sorts)) {
            $sort = "ORDER BY " . implode(" , ", $temp);
        }

        $limit = null;
        if ($qty_per_page) {
            $start = $page_index * $qty_per_page;
            $limit = "LIMIT $start, $qty_per_page";
        }

        return $this->fetchAll($condition, $sort, $limit);
    }

    // Find a product by its ID
    function find($id)
    {
        global $conn;
        $condition = "id = $id";
        $products = $this->fetchAll($condition);
        $product = current($products);
        return $product;
    }

    // Find a product by its barcode
    function findByBarcode($barcode)
    {
        global $conn;
        $condition = "barcode = '$barcode'";
        $products = $this->fetchAll($condition);
        $product = current($products);
        return $product;
    }

    // Save a new product to the database
    function save($data)
    {
        global $conn;
        $name = $data["name"];
        $price = $data["price"];
        $featured_image = $data["featured_image"];
        $inventory_qty = $data["inventory_qty"];
        $category_id = $data["category_id"];
        $brand_id = $data["brand_id"];
        $created_date = $data["created_date"];
        $description = $data["description"];
        $enter_price = $data["enter_price"];
        $deleted = $data["deleted"];
        $updated_at = $data["updated_at"];
        $featured = $data["featured"];

        $sql = "INSERT INTO product (name, price, featured_image, inventory_qty, category_id, brand_id, created_date, description, enter_price, deleted, updated_at, featured) 
        VALUES ('$name', $price, '$featured_image', $inventory_qty, $category_id, $brand_id, '$created_date', '$description', $enter_price, $deleted, '$updated_at', '$featured')";

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            return $last_id;
        }
        $this->error =  "Error: " . $sql . PHP_EOL . $conn->error;
        return false;
    }

    // Update product information
    function update(Product $product)
    {
        global $conn;

        $id = $product->getId();
        $name = $product->getName();
        $price = $product->getPrice();
        $featured_image = $product->getFeaturedImage();
        $inventory_qty = $product->getInventoryQty();
        $category_id = $product->getCategoryId();
        $brand_id = $product->getBrandId();
        $created_date = $product->getCreatedDate();
        $description = $product->getDescription();
        $enter_price = $product->getEnterPrice();
        $deleted = $product->getDeleted();
        $updated_at = $product->getUpdatedAt();
        $featured = $product->getFeatured();

        $sql = "UPDATE product SET 
        name='$name',
        price=$price,
        featured_image='$featured_image',
        inventory_qty=$inventory_qty,
        category_id=$category_id,
        brand_id=$brand_id,
        created_date='$created_date',
        description='$description',
        enter_price=$enter_price,
        deleted=$deleted,
        updated_at='$updated_at',
        featured='$featured'
        WHERE id=$id";


        if ($conn->query($sql) === TRUE) {
            return true;
        }
        $this->error =  "Error: " . $sql . PHP_EOL . $conn->error;
        return false;
    }

    // Delete a product from the database
    function delete(Product $product)
    {
        global $conn;
        $id = $product->getId();
        $sql = "DELETE FROM product WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            return true;
        }
        $this->error =  "Error: " . $sql . PHP_EOL . $conn->error;
        return false;
    }

    // Get products based on a specified pattern
    function getByPattern($pattern)
    {
        $condition = "name like '%$pattern%'";
        return $this->fetchAll($condition);
    }
}
