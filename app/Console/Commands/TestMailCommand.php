<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'メール送信のテストコマンド';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('メール送信テストを開始します...');
        $this->info('送信先: ' . $email);
        $this->info('');
        $this->info('--- メール設定 ---');
        $this->info('MAIL_DRIVER: ' . config('mail.driver'));
        $this->info('MAIL_HOST: ' . config('mail.host'));
        $this->info('MAIL_PORT: ' . config('mail.port'));
        $this->info('MAIL_USERNAME: ' . config('mail.username'));
        $this->info('MAIL_ENCRYPTION: ' . config('mail.encryption'));
        $this->info('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        $this->info('MAIL_FROM_NAME: ' . config('mail.from.name'));
        $this->info('');

        try {
            Mail::raw('これはテストメールです。日本語が正しく表示されていますか？', function ($message) use ($email) {
                $message->to($email)
                        ->subject('【テスト】メール送信テスト');
            });
            
            $this->info('✓ メール送信に成功しました！');
            $this->info('Gmailの受信トレイまたは迷惑メールフォルダを確認してください。');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('✗ メール送信に失敗しました');
            $this->error('エラー: ' . $e->getMessage());
            $this->error('');
            $this->error('スタックトレース:');
            $this->error($e->getTraceAsString());
            
            return 1;
        }
    }
}
