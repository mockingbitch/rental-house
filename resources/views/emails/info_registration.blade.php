@component('mail::message')
<p>{{ $data['first_name'] }}様</p>
<p>いつもお世話になっております。</p>
<p>この度はアカウントの登録ありがとうございました。</p>
<p>以下のURLからアカウント登録内容の確認、変更が可能です。</p>
@component('mail::button', ['url' => $data['url']])
アカウント登録 URL
@endcomponent
<p>========== </p>
<p>*本メールは、自動的に配信しています。また送信専用のため、直接ご返信いただいてもお問い合わせにはお答えできませんので、あらかじめご了承ください。</p>
<p> ==========</p>

{{ config('app.name') }}
@endcomponent