@component('mail::message')
# DotTrees
<p>いつもお世話になっております。 この度はメールアドレスの登録ありがとうございました。</p>
<p>以下のURLからアカウント登録のご対応をお願いいたします。</p>
<p>本メールの有効期限は 24時間です。 (期限 : {{ $data['expires_in'] }} ) </p>
@component('mail::button', ['url' => route('user.information', ['token' => $data['remember_token']])])
アカウント登録 URL
@endcomponent
<p>========== </p>
<p>*本メールは、自動的に配信しています。また送信専用のため、直接ご返信いただいてもお問い合わせにはお答えできませんので、あらかじめご了承ください。</p>
<p> ==========</p>

{{ config('app.name') }}
@endcomponent