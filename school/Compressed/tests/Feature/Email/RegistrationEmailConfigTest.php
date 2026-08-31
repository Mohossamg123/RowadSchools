<?php

namespace Tests\Feature\Email;

use Tests\TestCase;

class RegistrationEmailConfigTest extends TestCase
{
    public function test_registration_email_uses_mail_registration_email_env(): void
    {
        $this->assertSame(
            env('MAIL_REGISTRATION_EMAIL', env('MAIL_FROM_ADDRESS')),
            config('mail.registration_email')
        );
    }
}
