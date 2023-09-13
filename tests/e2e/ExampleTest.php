<?php

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\Admin;


// class InMemoryRepository
// {
//     private $data = [];

//     public function findAll(): array
//     {
//         return $this->data;
//     }

//     public function findById(int $id)
//     {
//         return $this->data[$id] ?? null;
//     }

//     public function add(array $item): int
//     {
//         $id = count($this->data);
//         $this->data[$id] = $item;
//         return $id;
//     }

//     public function update(int $id, array $item): void
//     {
//         if (isset($this->data[$id])) {
//             $this->data[$id] = $item;
//         }
//     }

//     public function delete(int $id): void
//     {
//         unset($this->data[$id]);
//     }
// }

// class YourController extends AbstractController
// {
//     private $adminUrlGenerator;

//     public function __construct(AdminUrlGenerator $adminUrlGenerator)
//     {
//         $this->adminUrlGenerator = $adminUrlGenerator;
//     }

//     #[Route('/admin/sync', name: 'admin_sync')]
//     public function sync()
//     {

//         $url = $this->adminUrlGenerator
//             ->setController(AdCrudController::class)
//             ->setAction(Action::INDEX)
//             ->generateUrl();

//         return $this->redirect($url);

//     }
// }

// $repository = new InMemoryRepository();

// it('should have 1 more item', function () {
//     $url = $this->adminUrlGenerator
//         ->setController(SyncCrudController::class)
//         ->setAction(Action::INDEX)
//         ->generateUrl();
//     dd($url);
//     $crawler = $this->client->request('GET' , $url);

//     $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    
//     $this->assertSelectorTextContains('span', 'AddYourAd');
// });
