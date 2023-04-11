document.addEventListener('DOMContentLoaded', function () {
  const translationCheckbox = document.querySelector('input[name="text2image_generator_enable_translation"]');
  const originalText = "�f�B�Y�j�[�����h, ����, �{���̎ʐ^, �N���[��."; 
  const translatedText = "Disneyland, Tokyo, real photo, clean.";

  function text2image_generator_toggleTranslation() {
    if (translationCheckbox.checked) {
      console.log('Translated Prompt: ' + translatedText);
    } else {
      console.log('Original Prompt: ' + originalText);
    }
  }

  translationCheckbox.addEventListener('change', text2image_generator_toggleTranslation);
  text2image_generator_toggleTranslation(); // Call it once to set the initial state
});
