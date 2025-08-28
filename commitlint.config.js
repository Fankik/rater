export default {
  plugins: [
    {
      rules: {
        'rt-ticket-format': (parsed) => {
          const { subject, header } = parsed;
          const message = subject || header;

          if (!message) {
            return [false, 'Сообщение коммита не может быть пустым'];
          }

          const rtPattern = /^RT-\d+/;
          if (!rtPattern.test(message)) {
            return [false, 'Сообщение коммита должно начинаться с "RT-XXX" (например: RT-123: исправить баг логина)'];
          }

          const fullPattern = /^RT-\d+\s[A-ZА-Я]/;
          if (!fullPattern.test(message)) {
            return [
              false,
              'После RT-XXX должен идти пробел и первый символ описания должен быть с большой буквы (например: RT-123 Исправить баг логина)',
            ];
          }

          if (message.length > 80) {
            return [false, 'Сообщение коммита не должно превышать 80 символа'];
          }

          return [true, ''];
        },
      },
    },
  ],
  rules: {
    'rt-ticket-format': [2, 'always'],
    'subject-empty': [0],
    'header-max-length': [2, 'always', 80],
  },
};
