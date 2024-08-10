# Lazy Blogger's AI Image Generator
Contributors: Anonymous_Producer  
Tags: ai, automated image generation, featured image, openai, dall-e  
Requires WordPress: 6.1.1 or higher  
Tested up to WordPress: 6.6.1  
Requires PHP: 8.1 or higher  
Stable tag: 1.3  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically generate featured images for your posts using OpenAI's DALL-E API.

## Description

I made this WordPress Plugin just for fun. 

If you are too lazy to look for a featured image for your post, this one might be the solution for you.

Lazy Blogger's AI Image Generator is a WordPress plugin that automatically creates featured images for your posts using OpenAI's DALL-E API. Good for lazy bloggers who want to save time on image selection.

**Key Features:**
* Generates images automatically when a post is published
* Uses post title, category, and tags to create image prompt
* Or you can let AI read your post content to generate image prompt
* Additional style prompt for fine-tuning generated images

## Requirements

* WordPress 6.1.1 or higher
* PHP 8.1 or higher
* OpenAI API key

## Installation

1. Ensure your server meets the requirements, especially PHP 8.1 or higher.
2. Upload the plugin zip file to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress
4. Use the TUBM Plugins->Lazy Blogger's AI Image Generator screen to configure the plugin
5. Enter your OpenAI API Key in the settings

## Settings

1. **API Key:** Enter your OpenAI API Key.
2. **Size:** Choose the size of the generated images (1024x1024, 1024x1792, or 1792x1024).
3. **Include Title/Category/Tag:** Check these boxes to include the title, category, and tags in the API prompt.
4. **Create prompt from the post content:** Enable this if you want AI to generate an image prompt from the post content.
5. **Additional Style Prompt:** Use this to include style information in the prompt.
6. **Enable Logging:** Enable this to save logs for troubleshooting.

## Note

This plugin requires an OpenAI API key to function. Make sure you have an active OpenAI account and API key before using this plugin.

## Changelog

### 1.3
* Added function calling to generate prompts from post content

### 1.2
* I can't remember

### 1.1
* Bug fixes and performance improvements

### 1.0
* Initial release