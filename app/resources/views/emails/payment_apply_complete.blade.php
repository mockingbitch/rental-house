@component('mail::message')
# Rental House
<p>{{ $user['first_name'] }} 様</p>
<p>いつもお世話になっております。</p>
<p>この度はレッスンの予約ありがとうございました。</p>
 
<p>確認用URL: <a href="#">URL</a></p>

<p>オンランレッスン詳細は以下になります。</p>

<p>日時 : {{ $data['lesson']['start_date'] }} {{ $data['course']['start_time'] }} - {{ $data['course']['end_time'] }}</p>
<p>レッスンタイトル {{ $data['lesson']['title']}}</p>
<p>レッスン時間 {{ $data['lesson']['lesson_time_in_minute'] }} min</p>
<p>先生名 : {{ $data['teacher']['first_name'] }} {{ $data['teacher']['last_name'] }}</p>
<p>zoom URL <a href="#">URL</a></p>

<p>========== </p>
<p>*本メールは、自動的に配信しています。また送信専用のため、直接ご返信いただいてもお問い合わせにはお答えできませんので、あらかじめご了承ください。</p>
<p>==========</p>

{{ config('app.name') }}
@endcomponent