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
