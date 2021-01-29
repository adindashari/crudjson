<?php

namespace App\Controller;

use App\Repository\IdentityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class IdentityController
{
    /**
     * @Route("/identity", name="identity")
     */
     public $identityRepository;

     public function __construct(IdentityRepository $identityRepository){
         $this->identityRepository = $identityRepository;
     }
    
     public function addIdentity(Request $request): JsonResponse{
        $data = json_decode($request->getContent(), true);

        $Nama = $data['nama'];
        $Telp = $data['telp'];
        $Email = $data['email'];
        $Alamat = $data['alamat'];

        if (empty($Nama) || empty($Telp) || empty($Email) || empty($Alamat)){
            throw new NotFoundHttpException('Excepting mandatory parameters');
        }

        $this->identityRepository->simpanIdentity($Nama, $Telp, $Email, $Alamat);

        return new JsonResponse(['status' => 'Data tersimpan'], Response::HTTP_CREATED);
         
     }

     public function getIdentity($id): JsonResponse{
         $identity = $this->identityRepository->findByOne(['id' => $id]);

         $data = [
             'id' => $identity->getId(),
             'nama' => $identity->getNama(),
             'telp' => $identity->getTelp(),
             'email' => $identity->getEmail(),
             'alamat' => $identity->getAlamat(),
         ];

         return new JsonResponse (['identity' => $data], Response::HTTP_OK);
     }

     public function getAllIdentities(): JsonResponse{
         $identity = $this->identityRepository->findAll();
         $data[] = [
            'id' => $identity->getId(),
            'nama' => $identity->getNama(),
            'telp' => $identity->getTelp(),
            'email' => $identity->getEmail(),
            'alamat' => $identity->getAlamat(),
        ];

        return new JsonResponse (['identities' => $data], Response::HTTP_OK);
     }


     public function updateIdentity($id, Request $request): JsonResponse{
        $identity = $this->identityRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        $this->identityRepository->revisiIdentity($identity, $data);

        return new JsonResponse(['status' => 'data terupdate']);
    }

    public function deleteIdentity($id): JsonResponse{
        $identity = $this->identityRepository->findOneBy(['id' => $id]);

        $this->identityRepository->hapusIdentity($identity);

        return new JsonResponse(['status' => 'data terhapus']);
    }








    /**public function createIdentity(): Response{
        $entityManager = $this->getDoctrine()->getManager();

        $identity = new Identity();
        $identity->setNama('Queen Cheori');
        $identity->setTelp('081234345453');
        $identity->setEmail('qc@gmail.com');
        $identity->setAlamat('joseon street');

        $entityManager->persist($identity);
        $entityManager->flush();

        return new Response('Simpan identitas dengan id '.$identity->getId());
    }

    public function show(int $id, IdentityRepository $identityRepository): Response{
        $identity = $identityRepository
        ->find($id);

        return new Response('Data: '.$identity->getNama());

    }

    public function update(int $id): Response{
        $identityManager = $this->getDoctrine()->getManager();

        $identity = $identityManager->getRepository(Identity::class)->find($id);
        if(!$identity){
            throw $this->createNotFoundException('Tidak ditemukan data'.$id);
        }

        $identity->setNama('Kim So Yong');
        $identityManager->flush();

        return $this->redirectToRoute('show_identity', ['id' => $identity->getId()]);
    }

    public function delete(int $id): Response{
        $identityManager = $this->getDoctrine()->getManager();

        $identity = $identityManager->getRepository(Identity::class)->find($id);
        if(!$identity){
            throw $this->createNotFoundException('Tidak ditemukan data'.$id);
        }

        $identityManager->remove($identity);
        $identityManager->flush();

        return new Response('Data berhasil dihapus');
    }

    public function search(int $id): Response{
        $identity = $this->getDoctrine()->getRepository(Identity::class)->find($id);

        if(!$identity){
            throw $this->createNotFoundException('Data tidak ditemukan'.$id);
        }

        return new Response('Data yang dicari: '.$identity->getNama());
    }
    */
}
