<?php

use PHPUnit\Framework\TestCase;
use Rakit\Validation\Validator;
use App\Service\UserService;
use App\Repository\PdoUserRepository;

class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var PdoUserRepository
     */
    private $repository;

    public function setup(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(PdoUserRepository::class);
        $this->userService = new UserService($this->repository);

    }

    public function testIsEmailExisted()
    {
        $user = new stdClass();
        $email = "ahmed@gmail.com";
        $this->repository->shouldReceive('findByEmail')->with($email)->andReturn($user);
        $this->assertEquals($this->userService->isEmailExisted($email), true);
    }

    public function testCreateUSer()
    {
        $this->repository->shouldReceive('create')->andReturn(1);
        $this->assertEquals($this->userService->create("name", "email", "password", 1), 1);
    }

    public function ValidationDataProvider(): array
    {
        return [
            [
                "inputs" => [
                    "email" => "ahmed",
                    "password" => "123",
                    "confirm_password" => "123456",
                    "role_id" => ""
                ],
                "isFailed" => true,
                "errors" => [
                    'email' => 'The Email is not valid email',
                    'password' => 'The Password minimum is 6',
                    'name' => 'The Name is required',
                    "confirm_password" => "The Confirm password must be same with password"
                ],
                "roles" => "1,2,3"
            ],
            [
                "inputs" => [
                    "email" => "ahmed@yahoo.com",
                    "password" => "123456",
                    "confirm_password" => "123456",
                    'name' => 'ahmed',
                    "role_id" => "4"
                ],
                "isFailed" => true,
                "errors" => [
                    'role_id' => "The Role id only allows '1', or '2'"
                ],
                "roles" => "1,2"
            ],
            [
                "inputs" => [
                    "email" => "ahmed@yahoo.com",
                    "password" => "123456",
                    "confirm_password" => "123456",
                    'name' => 'ahmed',
                    "role_id" => ""
                ],
                "isFailed" => false,
                "errors" => [],
                "roles" => ""
            ],
        ];
    }

    /**
     * @param array $inputs
     * @param bool $isFailed
     * @param array $errors
     * @param string $roles
     * @dataProvider ValidationDataProvider
     */
    public function testValidate(array $inputs, bool $isFailed, array $errors, string $roles)
    {
        $validator = new Validator;
        $validations = $this->userService->validate($validator, $inputs, $roles);
        $this->assertEquals($validations->fails(), $isFailed);
        $this->assertEquals($validations->errors()->firstOfAll(), $errors);
    }


}