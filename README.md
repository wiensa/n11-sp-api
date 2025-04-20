# N11 Seller Partner API for Laravel

Laravel için N11 Seller Partner API entegrasyonu.

N11 platformu ile entegrasyon sağlayarak, ürün yönetimi, sipariş takibi, kategori listeleme ve daha fazla işlemi programatik olarak gerçekleştirmenize olanak tanıyan bir Laravel paketidir.

## Özellikler

- N11 API ile kolay entegrasyon
- Kategorileri listeleme ve yönetme
- Ürünleri sorgulama, ekleme, güncelleme ve silme
- Siparişleri listeleme ve yönetme
- Şehir ve ilçe bilgilerini sorgulama
- Kargo şirketleri ve şablonlarını yönetme
- Ürün stok ve satış durumlarını yönetme

## Kurulum

Composer aracılığıyla paketi projenize ekleyin:

```bash
composer require wiensa/n11-sp-api
```

Paketi yükledikten sonra, N11 API yapılandırma dosyasını yayınlayın:

```bash
php artisan vendor:publish --provider="N11Api\N11SpApi\N11SpApiServiceProvider" --tag="config"
```

Bu komut, `config/n11-sp-api.php` yapılandırma dosyasını projenize ekleyecektir.

## Yapılandırma

`.env` dosyanıza N11 API anahtarlarınızı ekleyin:

```
N11_APP_KEY=your-app-key
N11_APP_SECRET=your-app-secret
```

Bu anahtarları N11 Seller Partner API panelinden alabilirsiniz.

## Kullanım

### Facade ile Kullanım

```php
use N11Api\N11SpApi\Facades\N11;

// Kategorileri listele
$categories = N11::categories()->getCategories();

// Ürün bilgilerini getir
$product = N11::products()->getProductById(123456);

// Siparişleri listele
$orders = N11::orders()->getOrders([
    'status' => 'New',
    'period' => [
        'startDate' => '01/01/2023',
        'endDate' => '31/12/2023'
    ]
]);
```

### Dependency Injection ile Kullanım

```php
use N11Api\N11SpApi\N11Api;

class ProductController extends Controller
{
    protected N11Api $n11;
    
    public function __construct(N11Api $n11)
    {
        $this->n11 = $n11;
    }
    
    public function getProducts()
    {
        $products = $this->n11->products()->getProducts([
            'currentPage' => 0,
            'pageSize' => 20
        ]);
        
        return $products;
    }
}
```

## Servisler

Paket, N11 API'sine erişmek için aşağıdaki servisleri içerir:

- **CategoryService**: Kategori işlemleri (`$n11->categories()`)
- **CityService**: Şehir ve ilçe işlemleri (`$n11->cities()`)
- **OrderService**: Sipariş işlemleri (`$n11->orders()`)
- **ProductService**: Ürün işlemleri (`$n11->products()`)
- **ShipmentService**: Teslimat şablonu işlemleri (`$n11->shipments()`)
- **ShipmentCompanyService**: Kargo şirketi işlemleri (`$n11->shipmentCompanies()`)
- **ProductSellingService**: Ürün satış durumu işlemleri (`$n11->productSellings()`)
- **ProductStockService**: Ürün stok işlemleri (`$n11->productStocks()`)

Her servis, ilgili N11 API metodlarını içerir ve belgeli metodlarla kolay kullanım sağlar.

## Örnek Uygulamalar

### Kategori Listeleme

```php
// Tüm kategorileri getir
$categories = N11::categories()->getCategories();

// Kategori detaylarını döngü ile işle
foreach ($categories as $category) {
    echo "Kategori ID: " . $category->id . "\n";
    echo "Kategori Adı: " . $category->name . "\n";
    
    // Alt kategorileri getir
    $subCategories = N11::categories()->getSubCategories($category->id);
    
    // Alt kategorileri işle
    foreach ($subCategories as $subCategory) {
        echo "  Alt Kategori ID: " . $subCategory->id . "\n";
        echo "  Alt Kategori Adı: " . $subCategory->name . "\n";
    }
}
```

### Ürün Ekleme

```php
$product = [
    'productSellerCode' => 'PRD-123456',
    'title' => 'Örnek Ürün',
    'subtitle' => 'Örnek Alt Başlık',
    'description' => 'Ürün açıklama metni',
    'category' => [
        'id' => 1000123
    ],
    'price' => 99.90,
    'currencyType' => 'TL',
    'images' => [
        'image' => [
            [
                'url' => 'https://example.com/image1.jpg',
                'order' => 1
            ],
            [
                'url' => 'https://example.com/image2.jpg',
                'order' => 2
            ]
        ]
    ],
    'stockItems' => [
        'stockItem' => [
            [
                'quantity' => 10,
                'sellerStockCode' => 'STK-123456'
            ]
        ]
    ],
    'shipmentTemplate' => 'Standart Teslimat'
];

$result = N11::products()->createProduct($product);
```

### Siparişleri Listeleme

```php
$orders = N11::orders()->getOrders([
    'status' => 'New', // New, Approved, Rejected, Shipped, Delivered, Completed
    'period' => [
        'startDate' => '01/01/2023',
        'endDate' => '31/12/2023'
    ],
    'pagingData' => [
        'currentPage' => 0,
        'pageSize' => 20
    ]
]);

// Siparişleri işle
foreach ($orders->orderList->order as $order) {
    echo "Sipariş ID: " . $order->id . "\n";
    echo "Sipariş Numarası: " . $order->orderNumber . "\n";
    echo "Alıcı: " . $order->buyer->fullName . "\n";
    
    // Sipariş detayını getir
    $orderDetail = N11::orders()->getOrderDetail($order->id);
    
    // Sipariş kalemlerini işle
    foreach ($orderDetail->orderItems as $item) {
        echo "  Ürün: " . $item->productName . "\n";
        echo "  Adet: " . $item->quantity . "\n";
        echo "  Fiyat: " . $item->price . "\n";
    }
}
```

### Ürün Stok Yönetimi

```php
// Ürün stoğunu sorgula
$stockInfo = N11::productStocks()->getProductStockByProductId(123456);

// Stok güncelle
$stockParams = [
    'items' => [
        [
            'productId' => 123456,
            'quantity' => 100,
            'version' => $stockInfo->version
        ]
    ]
];

$result = N11::productStocks()->updateProductStock($stockParams);
```

### Ürün Satış Durum Yönetimi

```php
// Ürünü satışa kapat
$result = N11::productSellings()->stopSellingProductByProductId(123456);

// Ürünü satışa aç
$result = N11::productSellings()->startSellingProductByProductId(123456);
```

## Sürüm Değişiklikleri

### 1.x

- N11Api sınıfı ve namespace güncellemeleri
- Servis metot adları güncellendi (çoğul yapıldı: categories(), cities(), vb.)
- Daha tutarlı bir API arayüzü eklendi
- PHP 8.3 desteği eklendi

## Lisans

Bu paket MIT lisansı altında lisanslanmıştır. 