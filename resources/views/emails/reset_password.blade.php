<h1>Olá, {{ $userName }}!</h1>
<p>Você solicitou a recuperação de senha para sua conta no Finance App.</p>
<p>Clique no botão abaixo para redefinir sua senha:</p>
<a href="{{ $resetLink }}" style="background: blue; color: white; padding: 10px; text-decoration: none;">
    Redefinir Minha Senha
</a>
<p>Se você não solicitou isso, ignore este e-mail.</p>
