<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use function Pest\Laravel\post;

it('an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();
    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class);
});

it('an email was sent to user:x', function () {
    Mail::fake();

    $user = User::factory()->create();
    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class, function (WelcomeEmail $email) use ($user) {
        return $email->hasTo($user->email);
    });

    Mail::assertSent(WelcomeEmail::class, fn (WelcomeEmail $email)=> $email->assertHasTo($user->email));

});

it('email subject should contain the user name', function () {

    $user = User::factory()->create();
    $mail = new WelcomeEmail($user);
    $mail->to = $user->email;

    expect($mail)
        ->assertHasSubject('Thank you ' . $user->name);
});

it('email content should contain user email with a text', function () {

    $user = User::factory()->create();
    $mail = new WelcomeEmail($user);

    expect($mail)
        ->assertSeeInHtml($user->email)
        ->assertSeeInHtml('Confimando que o seu email eh: ', $user->email);
});
