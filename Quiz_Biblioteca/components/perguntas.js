const perguntas = [
  {
    pergunta: "Qual autor escreveu o livro 'Dom Casmurro'?",
    opcoes: [
      { texto: "Machado de Assis", valor: 10 },
      { texto: "José de Alencar", valor: 0 },
      { texto: "Érico Veríssimo", valor: 0 },
      { texto: "Monteiro Lobato", valor: 0 },
    ],
  },
  {
    pergunta: "Qual é o título do primeiro livro da série 'Harry Potter'?",
    opcoes: [
      { texto: "Harry Potter e a Pedra Filosofal", valor: 10 },
      { texto: "Harry Potter e o Cálice de Fogo", valor: 0 },
      { texto: "Harry Potter e as Relíquias da Morte", valor: 0 },
      { texto: "Harry Potter e o Prisioneiro de Azkaban", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'Orgulho e Preconceito'?",
    opcoes: [
      { texto: "Jane Austen", valor: 10 },
      { texto: "Charles Dickens", valor: 0 },
      { texto: "Emily Brontë", valor: 0 },
      { texto: "F. Scott Fitzgerald", valor: 0 },
    ],
  },
  {
    pergunta:
      "Em que livro o personagem Frodo Bolseiro embarca em uma jornada para destruir um anel?",
    opcoes: [
      { texto: "O Senhor dos Anéis: A Sociedade do Anel", valor: 10 },
      {
        texto: "As Crônicas de Nárnia: O Leão, a Feiticeira e o Guarda-Roupa",
        valor: 0,
      },
      { texto: "Percy Jackson e o Ladrão de Raios", valor: 0 },
      { texto: "A Torre Negra: O Pistoleiro", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um naufrago em uma ilha deserta com um amigo imaginário chamado Sexta-feira?",
    opcoes: [
      { texto: "Robinson Crusoé", valor: 10 },
      { texto: "Moby Dick", valor: 0 },
      { texto: "A Ilha do Tesouro", valor: 0 },
      { texto: "Aventuras de Alice no País das Maravilhas", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor do livro 'A Metamorfose'?",
    opcoes: [
      { texto: "Franz Kafka", valor: 10 },
      { texto: "Fyodor Dostoevsky", valor: 0 },
      { texto: "Leo Tolstoy", valor: 0 },
      { texto: "George Orwell", valor: 0 },
    ],
  },
  {
    pergunta: "Qual é o livro mais vendido de todos os tempos?",
    opcoes: [
      { texto: "A Bíblia Sagrada", valor: 10 },
      { texto: "Dom Quixote", valor: 0 },
      { texto: "O Pequeno Príncipe", valor: 0 },
      { texto: "Cem Anos de Solidão", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu '1984'?",
    opcoes: [
      { texto: "George Orwell", valor: 10 },
      { texto: "Aldous Huxley", valor: 0 },
      { texto: "Ray Bradbury", valor: 0 },
      { texto: "Philip K. Dick", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do primeiro livro da série 'As Crônicas de Gelo e Fogo'?",
    opcoes: [
      { texto: "A Guerra dos Tronos", valor: 10 },
      { texto: "A Tormenta de Espadas", valor: 0 },
      { texto: "A Fúria dos Reis", valor: 0 },
      { texto: "O Festim dos Corvos", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'A Culpa é das Estrelas'?",
    opcoes: [
      { texto: "John Green", valor: 10 },
      { texto: "J.K. Rowling", valor: 0 },
      { texto: "Stephen King", valor: 0 },
      { texto: "Veronica Roth", valor: 0 },
    ],
  },
  {
    pergunta: "Qual é o título do livro que inspirou o filme 'Clube da Luta'?",
    opcoes: [
      { texto: "Clube da Luta", valor: 0 },
      { texto: "O Estrangeiro", valor: 0 },
      { texto: "O Lobo da Estepe", valor: 0 },
      { texto: "Fight Club", valor: 10 },
    ],
  },
  {
    pergunta: "Quem escreveu 'O Alquimista'?",
    opcoes: [
      { texto: "Paulo Coelho", valor: 10 },
      { texto: "Gabriel Garcia Marquez", valor: 0 },
      { texto: "Haruki Murakami", valor: 0 },
      { texto: "Fyodor Dostoevsky", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um jovem que se muda para Long Island e se torna vizinho de um misterioso milionário?",
    opcoes: [
      { texto: "O Grande Gatsby", valor: 10 },
      { texto: "Moby Dick", valor: 0 },
      { texto: "As Vinhas da Ira", valor: 0 },
      { texto: "O Sol é para Todos", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Hobbit'?",
    opcoes: [
      { texto: "J.R.R. Tolkien", valor: 10 },
      { texto: "C.S. Lewis", valor: 0 },
      { texto: "J.K. Rowling", valor: 0 },
      { texto: "Philip Pullman", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um menino que descobre que é um bruxo no seu aniversário de onze anos?",
    opcoes: [
      { texto: "Harry Potter e a Pedra Filosofal", valor: 10 },
      {
        texto: "As Crônicas de Nárnia: O Leão, a Feiticeira e o Guarda-Roupa",
        valor: 0,
      },
      { texto: "Percy Jackson e o Ladrão de Raios", valor: 0 },
      { texto: "A Torre Negra: O Pistoleiro", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Senhor dos Anéis'?",
    opcoes: [
      { texto: "J.R.R. Tolkien", valor: 10 },
      { texto: "George R.R. Martin", valor: 0 },
      { texto: "C.S. Lewis", valor: 0 },
      { texto: "J.K. Rowling", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de crianças que descobrem um armário mágico que leva a um mundo encantado?",
    opcoes: [
      {
        texto: "As Crônicas de Nárnia: O Leão, a Feiticeira e o Guarda-Roupa",
        valor: 10,
      },
      { texto: "Harry Potter e a Pedra Filosofal", valor: 0 },
      { texto: "Percy Jackson e o Ladrão de Raios", valor: 0 },
      { texto: "A Torre Negra: O Pistoleiro", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'A Moreninha'?",
    opcoes: [
      { texto: "Joaquim Manuel de Macedo", valor: 10 },
      { texto: "Machado de Assis", valor: 0 },
      { texto: "José de Alencar", valor: 0 },
      { texto: "Álvares de Azevedo", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um naufrago em uma ilha deserta com um amigo imaginário chamado Sexta-feira?",
    opcoes: [
      { texto: "Robinson Crusoé", valor: 10 },
      { texto: "Moby Dick", valor: 0 },
      { texto: "A Ilha do Tesouro", valor: 0 },
      { texto: "Aventuras de Alice no País das Maravilhas", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Primo Basílio'?",
    opcoes: [
      { texto: "José Maria de Eça de Queirós", valor: 10 },
      { texto: "Machado de Assis", valor: 0 },
      { texto: "Aluísio Azevedo", valor: 0 },
      { texto: "Camilo Castelo Branco", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um homem que se transforma em um inseto gigante?",
    opcoes: [
      { texto: "A Metamorfose", valor: 10 },
      { texto: "O Processo", valor: 0 },
      { texto: "O Castelo", valor: 0 },
      { texto: "A Colônia Penal", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'Grande Sertão: Veredas'?",
    opcoes: [
      { texto: "João Guimarães Rosa", valor: 10 },
      { texto: "Machado de Assis", valor: 0 },
      { texto: "Érico Veríssimo", valor: 0 },
      { texto: "Monteiro Lobato", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um menino que descobre que é um bruxo e frequenta uma escola de magia?",
    opcoes: [
      { texto: "Harry Potter e a Pedra Filosofal", valor: 10 },
      {
        texto: "As Crônicas de Nárnia: O Leão, a Feiticeira e o Guarda-Roupa",
        valor: 0,
      },
      { texto: "Percy Jackson e o Ladrão de Raios", valor: 0 },
      { texto: "A Torre Negra: O Pistoleiro", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'Memórias Póstumas de Brás Cubas'?",
    opcoes: [
      { texto: "Machado de Assis", valor: 10 },
      { texto: "Joaquim Maria Machado de Assis", valor: 0 },
      { texto: "José de Alencar", valor: 0 },
      { texto: "Álvares de Azevedo", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de uma menina que cai em um buraco e se depara com um mundo surreal?",
    opcoes: [
      { texto: "Alice no País das Maravilhas", valor: 10 },
      { texto: "O Mágico de Oz", valor: 0 },
      { texto: "Peter Pan", valor: 0 },
      { texto: "O Pequeno Príncipe", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'O Pequeno Príncipe'?",
    opcoes: [
      { texto: "Antoine de Saint-Exupéry", valor: 10 },
      { texto: "J.K. Rowling", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de animais que vivem em uma fazenda e se rebelam contra os humanos?",
    opcoes: [
      { texto: "A Revolução dos Bichos", valor: 10 },
      { texto: "A Ilha dos Cachorros", valor: 0 },
      { texto: "O Poderoso Chefão", valor: 0 },
      { texto: "A Máquina do Tempo", valor: 0 },
    ],
  },
];
