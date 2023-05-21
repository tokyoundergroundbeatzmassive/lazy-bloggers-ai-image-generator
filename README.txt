=== text2image-generator ===
Contributors: Anonymous_Producer
Tags: ai, automated image generation
Requires at least: 6.1.1
Tested up to: 6.2
Stable tag: 1.3


↓↓↓English Below↓↓↓

「text2image-generator」について
このWordPressプラグインは、記事のタイトル、カテゴリー、タグを基に、記事が'公開'されるとOpenAIのAPIを利用して自動でアイキャッチ画像を生成します。

設定:
	1.	API Key: OpenAIのAPI Keyを入力します。
	2.	Size: 生成する画像のサイズを選択します。
	3.	Include Title/Category/Tag: それぞれのチェックボックスを入れると、APIに送られるプロンプトにタイトル、カテゴリー、タグが含まれるようになります。
	4.	Enable Translation: 有効にすると、APIに送られる最終的なプロンプトが英語に翻訳されます。
	5.	Prompt: スタイルやシーンをプロンプトに含めるために使います。
	6.	Enable Logging: 有効にするとログを保存します。

依存関係:
OpenAIのAPIを利用して画像を生成するため、API Keyが必要です。
'Enable Translation'が有効の場合、Open AIのAPIにリクエストを送ります。無効な場合には送りません。
画像を生成するためにOpen AIのAPIにプロンプトを送ります。
プラグインフォルダ内にあるSettings.jsで'Enable Translation'を有効・無効を切り替えています。



~English~
About "text2image-generator"
This WordPress plugin automatically generates featured images for your posts using OpenAI's API when the post is published, based on the title, category, and tags. 

Settings:
1. API Key: Enter your OpenAI API Key.
2. Size: Choose the size of the generated images.
3. Include Title/Category/Tag: Check these boxes to include the title, category, and tags in the API prompt.
4. Enable Translation: Enable this to translate the final prompt sent to the API into English.
5. Prompt: Use this to include style and scene information in the prompt.
6. Enable Logging: Enable this to save logs.

Dependencies:
As this plugin uses OpenAI's API to generate images, an API Key is required.
If 'Enable Translation' is enabled, the plugin will send requests to Open AI's API. It will not send requests if it is disabled.
The plugin sends prompts to Open AI's API to generate images.
The 'Enable Translation' toggle is located in the Settings.js file inside the plugin folder.