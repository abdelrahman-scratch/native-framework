<?php

use PHPUnit\Framework\TestCase;
use  App\Service\LoginService;
use App\Repository\PdoUserRepository;
use Rakit\Validation\Validator;

class LoginServiceTest extends TestCase
{
    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var PdoUserRepository
     */
    private $repository;

    public function setup(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(PdoUserRepository::class);
        $this->loginService = new LoginService($this->repository);
    }

    public function loginValidationDataProvider(): array
    {
        return [
            [
                "inputs" => [
                    "email" => "ahmed",
                    "password" => "123",
                ],
                "isFailed" => true,
                "errors" => [
                    'email' => 'The Email is not valid email',
                    'password' => 'The Password minimum is 6'
                ]
            ],
            [
                "inputs" => [
                    "email" => "ahmed@yahoo.com",
                ],
                "isFailed" => true,
                "errors" => [
                    'password' => 'The Password is required'
                ]
            ],
            [
                "inputs" => [
                    "email" => "ahmed@yahoo.com",
                    "password" => "123456",
                ],
                "isFailed" => false,
                "errors" => []
            ]
        ];

    }

    /**
     * @param array $inputs
     * @param bool $isFailed
     * @param array $errors
     * @dataProvider loginValidationDataProvider
     */
    public function testLoginValidation(array $inputs, bool $isFailed, array $errors)
    {
        $validator = new Validator;
        $validations = $this->loginService->validate($validator, $inputs);
        $this->assertEquals($validations->fails(), $isFailed);
        $this->assertEquals($validations->errors()->firstOfAll(), $errors);
    }

    public function testIsPasswordVerified()
    {
        $hash = '$2y$10$fdQOV4fCiG9maIs3UI8H3Oyp3vbxxH0hmw2w9OvN2Y1CJZvHv80p2';
        $password = '123456';
        $this->assertEquals(true, $this->loginService->isPasswordVerified($password, $hash));
        $this->assertEquals(false, $this->loginService->isPasswordVerified($password, $password));
    }

    public function testFindByEmail()
    {
        $user = new stdClass();
        $email = "ahmed@gmail.com";
        $this->repository->shouldReceive('findByEmailWithRole')->with($email)->andReturn($user);
        $this->assertEquals($this->loginService->findByEmailWithRole($email), $user);
    }

}