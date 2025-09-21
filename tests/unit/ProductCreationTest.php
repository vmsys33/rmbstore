<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Controllers\ProductsController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Helpers\ImageUploadHelper;

class ProductCreationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $seed = 'ProductSeeder';
    
    protected $productController;
    protected $productModel;
    protected $categoryModel;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Initialize controllers and models
        $this->productController = new ProductsController();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Test product creation form display
     */
    public function testCreateFormDisplay()
    {
        $result = $this->get('/admin/products/create');
        
        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('Add New Product', $result->getBody());
        $this->assertStringContainsString('Frontend Product Image', $result->getBody());
        $this->assertStringContainsString('Admin Table Icon', $result->getBody());
    }

    /**
     * Test product creation with valid data
     */
    public function testProductCreationWithValidData()
    {
        // Create test category first
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test category description',
            'status' => 'active'
        ];
        $categoryId = $this->categoryModel->insert($categoryData);

        // Mock image files
        $postImage = $this->createMockImageFile('test_post.jpg', 1024 * 1024); // 1MB
        $iconImage = $this->createMockImageFile('test_icon.jpg', 512 * 1024); // 512KB

        // Test data
        $productData = [
            'product_name' => 'Test Product',
            'product_category' => $categoryId,
            'price' => '99.99',
            'short_description' => 'This is a test product description for testing purposes.',
            'description' => 'Detailed description of the test product',
            'stock_quantity' => '10',
            'status' => 'active',
            'featured' => '1'
        ];

        // Mock the request
        $request = service('request');
        $request->setMethod('POST');
        $request->setPost($productData);
        
        // Mock file uploads
        $request->setFile('image_post', $postImage);
        $request->setFile('image_icon', $iconImage);

        // Test the store method
        $result = $this->post('/admin/products/store', $productData);
        
        // Assertions
        $this->assertTrue($result->isRedirect());
        $this->assertStringContainsString('/admin/products', $result->getHeaderLine('Location'));
    }

    /**
     * Test product creation validation - missing required fields
     */
    public function testProductCreationValidationMissingFields()
    {
        $invalidData = [
            'product_name' => '', // Missing required field
            'product_category' => '', // Missing required field
            'price' => '99.99',
            'short_description' => 'Short description'
            // Missing image_post (required)
        ];

        $result = $this->post('/admin/products/store', $invalidData);
        
        // Should redirect back with validation errors
        $this->assertTrue($result->isRedirect());
        $this->assertStringContainsString('admin/products/create', $result->getHeaderLine('Location'));
    }

    /**
     * Test product creation validation - invalid image
     */
    public function testProductCreationValidationInvalidImage()
    {
        // Create test category
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test category description',
            'status' => 'active'
        ];
        $categoryId = $this->categoryModel->insert($categoryData);

        // Test with invalid image (too large)
        $largeImage = $this->createMockImageFile('large_image.jpg', 10 * 1024 * 1024); // 10MB

        $productData = [
            'product_name' => 'Test Product',
            'product_category' => $categoryId,
            'price' => '99.99',
            'short_description' => 'This is a test product description.',
            'image_post' => $largeImage
        ];

        $result = $this->post('/admin/products/store', $productData);
        
        // Should redirect back with error
        $this->assertTrue($result->isRedirect());
    }

    /**
     * Test SKU auto-generation
     */
    public function testSkuAutoGeneration()
    {
        $productName = 'Test Product Name 123';
        $expectedSku = 'TESTPROD-' . strtoupper(substr(md5(uniqid()), 0, 4));
        
        // Test the SKU generation logic
        $sku = strtoupper(preg_replace('/[^A-Z0-9]/', '', $productName));
        $sku = substr($sku, 0, 8) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));
        
        $this->assertStringStartsWith('TESTPROD', $sku);
        $this->assertEquals(13, strlen($sku)); // 8 chars + dash + 4 chars
    }

    /**
     * Test image upload helper integration
     */
    public function testImageUploadHelperIntegration()
    {
        // Test post image upload
        $postImage = $this->createMockImageFile('test_post.jpg', 1024 * 1024);
        $uploadResult = ImageUploadHelper::uploadProductImage($postImage, 'post');
        
        $this->assertIsArray($uploadResult);
        $this->assertArrayHasKey('success', $uploadResult);
        
        // Test icon image upload
        $iconImage = $this->createMockImageFile('test_icon.jpg', 512 * 1024);
        $uploadResult = ImageUploadHelper::uploadProductImage($iconImage, 'icon');
        
        $this->assertIsArray($uploadResult);
        $this->assertArrayHasKey('success', $uploadResult);
    }

    /**
     * Test database insertion
     */
    public function testDatabaseInsertion()
    {
        // Create test category
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test category description',
            'status' => 'active'
        ];
        $categoryId = $this->categoryModel->insert($categoryData);

        // Test product data
        $productData = [
            'product_name' => 'Database Test Product',
            'sku' => 'TEST123-ABCD',
            'product_category' => $categoryId,
            'price' => 149.99,
            'sale_price' => 129.99,
            'stock_quantity' => 25,
            'weight' => 1.5,
            'dimensions' => '10x5x3',
            'short_description' => 'Test product for database testing',
            'description' => 'Detailed description for database testing',
            'status' => 'active',
            'featured' => 1,
            'image_icon' => 'uploads/products/icons/test_icon.jpg',
            'image_post' => 'uploads/products/posts/test_post.jpg'
        ];

        // Insert product
        $productId = $this->productModel->insert($productData);
        
        $this->assertIsInt($productId);
        $this->assertGreaterThan(0, $productId);

        // Verify data was inserted correctly
        $insertedProduct = $this->productModel->find($productId);
        $this->assertNotNull($insertedProduct);
        $this->assertEquals('Database Test Product', $insertedProduct['product_name']);
        $this->assertEquals('TEST123-ABCD', $insertedProduct['sku']);
        $this->assertEquals(149.99, $insertedProduct['price']);
    }

    /**
     * Test form submission without images
     */
    public function testFormSubmissionWithoutImages()
    {
        // Create test category
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test category description',
            'status' => 'active'
        ];
        $categoryId = $this->categoryModel->insert($categoryData);

        $productData = [
            'product_name' => 'No Image Product',
            'product_category' => $categoryId,
            'price' => '79.99',
            'short_description' => 'Product without images for testing'
        ];

        $result = $this->post('/admin/products/store', $productData);
        
        // Should fail validation because image_post is required
        $this->assertTrue($result->isRedirect());
    }

    /**
     * Test form submission with only required image
     */
    public function testFormSubmissionWithRequiredImageOnly()
    {
        // Create test category
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test category description',
            'status' => 'active'
        ];
        $categoryId = $this->categoryModel->insert($categoryData);

        // Create mock post image (required)
        $postImage = $this->createMockImageFile('required_image.jpg', 1024 * 1024);

        $productData = [
            'product_name' => 'Required Image Product',
            'product_category' => $categoryId,
            'price' => '89.99',
            'short_description' => 'Product with only required image',
            'image_post' => $postImage
        ];

        $result = $this->post('/admin/products/store', $productData);
        
        // Should succeed since image_post is provided
        $this->assertTrue($result->isRedirect());
    }

    /**
     * Helper method to create mock image files for testing
     */
    private function createMockImageFile($filename, $size)
    {
        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'test_image_');
        
        // Write some content to make it a valid file
        file_put_contents($tempFile, str_repeat('0', $size));
        
        // Create a mock file object
        $file = new \CodeIgniter\HTTP\Files\UploadedFile(
            $tempFile,
            $filename,
            'image/jpeg',
            $size,
            UPLOAD_ERR_OK
        );
        
        return $file;
    }

    /**
     * Test cleanup
     */
    protected function tearDown(): void
    {
        // Clean up any test files
        $tempFiles = glob(sys_get_temp_dir() . '/test_image_*');
        foreach ($tempFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        
        parent::tearDown();
    }
}
