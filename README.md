## laravel-demo-1

This repository showcases a demonstration of a monolithic REST architecture, designed to illustrate best practices and approaches in development. The entire functionality is documented using Swagger, providing comprehensive and clear API documentation. Additionally, every aspect of the application is covered with feature tests, ensuring code reliability and stability. This project serves as an excellent example of how to build scalable and maintainable RESTful services.

### Project Structure:
```
.
├── app
│   ├── Filters
│   │   ├── BaseFilters.php
│   │   └── Filterable.php
│   ├── Helpers
│   │   ├── DynamicResourceHelper.php
│   │   ├── RelationHelper.php
│   │   └── TranslationHelper.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Api
│   │   │   │   └── V1
│   │   │   │       ├── Admin
│   │   │   │       │   └── CategoryController.php
│   │   │   │       └── CategoryController.php
│   │   │   └── Controller.php
│   │   ├── Kernel.php
│   │   ├── Middleware
│   │   │   ├── ...
│   │   ├── Requests
│   │   │   └── V1
│   │   │       └── Admin
│   │   │           └── Category
│   │   │               └── CategoryRequest.php
│   │   └── Resources
│   │       ├── Admin
│   │       │   └── Category
│   │       │       ├── CategoryCollection.php
│   │       │       └── CategoryResource.php
│   │       └── Category
│   │           ├── CategoryCollection.php
│   │           └── CategoryResource.php
│   ├── Models
│   │   ├── Category.php
│   │   └── Translation.php
│   ├── Repositories
│   │   ├── BaseRepository.php
│   │   └── CategoryRepository.php
│   ├── Services
│   │   └── Api
│   │       └── V1
│   │           ├── Admin
│   │           │   └── CategoryService.php
│   │           └── CategoryService.php
│   └── Traits
│       └── MediaAbilityTrait.php
├── bootstrap
│   └── ...
├── config
│   └── ...
├── database
│   ├── factories
│   │   └── CategoryFactory.php
│   ├── migrations
│   │   ├── 2024_04_03_134701_create_course_categories_table.php
│   │   └── 2024_04_03_134725_create_course_category_translations_table.php
│   └── seeders
│       └── AdminUserSeeder.php
├── public
│   └── ...
└── tests
├── Feature
│   └── Api
│       └── V1
│           ├── Admin
│           │   └── CategoryTest.php
│           └── CategoryTest.php
└── TestCase.php
```

### Adding Translations to an Entity
To add translations to an entity, you need to extend the class with the HasTranslation trait. This involves defining the trait and specifying the translatable fields.

Use the HasTranslation trait in your model:

```php
class Category extends Model
{
    use HasTranslation;
}
```
Define the property and list all fields that need translation:
```php
    protected array $translationFillable = [
        'language',
        'category_id',
        'name',
        'meta_title',
        'meta_description',
        'short_description',
        'description',
    ];
```

### Preloading Files on the Server
To preload files on the server, use the MediaAbilityTrait trait in your model. Additionally, you need to prepare your model according to the instructions provided by Spatie's Laravel Media Library documentation: Preparing Your Model.

Use the MediaAbilityTrait and implement the HasMedia interface

```php
class Category extends Model implements HasMedia
{
    use InteractsWithMedia, MediaAbilityTrait;
}
```

### Base Repository for CRUD Operations
All repositories extend the BaseRepository, which contains standard CRUD methods. You only need to override the model property.

Extend BaseRepository in your repository:
```php
class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = Category::class;
    }
}
```

### Filtering Entities
To filter entities, use the Filterable trait in your repository file. Override the corresponding fields $this->filters and $this->sorts to add properties for filtering and sorting.

Use the Filterable trait in your repository:
```php
class CategoryRepository
{
    use Filterable;
    
    public function __construct()
    {
        $this->filters = ['status'];
        $this->sorts = ['sort'];
    }

```



