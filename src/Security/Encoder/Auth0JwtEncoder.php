<?php
declare(strict_types=1);

namespace App\Security\Encoder;

use Auth0\JWTAuthBundle\Security\Auth0Service;
use Firebase\JWT\JWT;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;

final class Auth0JwtEncoder implements JWTEncoderInterface
{
    /** @var \Auth0\JWTAuthBundle\Security\Auth0Service */
    private $auth0;

    /** @var string */
    private $privateKey;

    /**
     * Auth0JwtEncoder constructor.
     *
     * @param \Auth0\JWTAuthBundle\Security\Auth0Service $auth0
     * @param string $privateKey
     */
    public function __construct(Auth0Service $auth0, string $privateKey)
    {
        $this->auth0 = $auth0;
        $this->privateKey = $privateKey;
    }

    /**
     * {@inheritDoc}
     */
    public function encode(array $data)
    {
        try {
            // TODO Improve this
            return JWT::encode($data, $this->privateKey);
        } catch (\Exception $exception) {
            throw new JWTEncodeFailureException('whatever_reason', $exception->getMessage(), $exception);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function decode($token)
    {
        try {
            // TODO Improve this
            return (array)$this->auth0->decodeJWT($token);
        } catch (\Exception $exception) {
            throw new JWTDecodeFailureException('whatever_reason', $exception->getMessage(), $exception);
        }
    }
}
