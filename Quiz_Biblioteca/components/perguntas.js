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
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de animais que vivem em uma fazenda e se rebelam contra os humanos?",
    opcoes: [
      { texto: "A Revolução dos Bichos", valor: 10 },
      { texto: "A Ilha dos Cachorros", valor: 0 },
      { texto: "O Poderoso Chefão", valor: 0 },
      { texto: "A Máquina do Tempo", valor: 0 },
    ],
  },

  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de amigos que enfrentam um palhaço demoníaco?",
    opcoes: [
      { texto: "It", valor: 10 },
      { texto: "O Iluminado", valor: 0 },
      { texto: "Carrie, a Estranha", valor: 0 },
      { texto: "Cemitério Maldito", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'O Pequeno Príncipe'?",
    opcoes: [
      { texto: "Antoine de Saint-Exupéry", valor: 10 },
      { texto: "J.K. Rowling", valor: 0 },
      { texto: "Gabriel García Márquez", valor: 0 },
      { texto: "Leo Tolstoy", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um homem que perde a memória todos os dias?",
    opcoes: [
      { texto: "Amnésia", valor: 0 },
      { texto: "Memento Mori", valor: 0 },
      { texto: "O Estranho Caso de Benjamin Button", valor: 0 },
      { texto: "Amor nos Tempos do Cólera", valor: 10 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Código Da Vinci'?",
    opcoes: [
      { texto: "Dan Brown", valor: 10 },
      { texto: "J.R.R. Tolkien", valor: 0 },
      { texto: "George Orwell", valor: 0 },
      { texto: "Agatha Christie", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um jovem que se apaixona por uma mulher mais velha e misteriosa?",
    opcoes: [
      { texto: "Lolita", valor: 0 },
      { texto: "A Insustentável Leveza do Ser", valor: 0 },
      { texto: "O Amante de Lady Chatterley", valor: 0 },
      { texto: "O Amante de Lady Susan", valor: 10 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'A Redoma de Vidro'?",
    opcoes: [
      { texto: "Sylvia Plath", valor: 10 },
      { texto: "Virginia Woolf", valor: 0 },
      { texto: "Harper Lee", valor: 0 },
      { texto: "Margaret Atwood", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de exploradores em uma expedição ao centro da Terra?",
    opcoes: [
      { texto: "Viagem ao Centro da Terra", valor: 10 },
      { texto: "A Ilha do Tesouro", valor: 0 },
      { texto: "A Volta ao Mundo em 80 Dias", valor: 0 },
      { texto: "A Máquina do Tempo", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'A Morte de Ivan Ilitch'?",
    opcoes: [
      { texto: "Liev Tolstói", valor: 10 },
      { texto: "Fiódor Dostoiévski", valor: 0 },
      { texto: "Gustave Flaubert", valor: 0 },
      { texto: "James Joyce", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de uma família que vive escondida em um sótão durante a Segunda Guerra Mundial?",
    opcoes: [
      { texto: "O Diário de Anne Frank", valor: 10 },
      { texto: "A Revolução dos Bichos", valor: 0 },
      { texto: "A Menina que Roubava Livros", valor: 0 },
      { texto: "O Pequeno Príncipe", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Médico'?",
    opcoes: [
      { texto: "Noah Gordon", valor: 10 },
      { texto: "Ken Follett", valor: 0 },
      { texto: "John Grisham", valor: 0 },
      { texto: "Stephen King", valor: 0 },
    ],
  },

  {
    pergunta: "Quem é o autor de 'O Nome do Vento'?",
    opcoes: [
      { texto: "Patrick Rothfuss", valor: 10 },
      { texto: "Brandon Sanderson", valor: 0 },
      { texto: "George R.R. Martin", valor: 0 },
      { texto: "Terry Pratchett", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um homem que viaja no tempo em uma máquina do tempo por diferentes eras?",
    opcoes: [
      { texto: "A Máquina do Tempo", valor: 10 },
      { texto: "O Mundo Perdido", valor: 0 },
      { texto: "A Guerra dos Mundos", valor: 0 },
      { texto: "O Homem Invisível", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'O Médico e o Monstro'?",
    opcoes: [
      { texto: "Robert Louis Stevenson", valor: 10 },
      { texto: "Edgar Allan Poe", valor: 0 },
      { texto: "Mary Shelley", valor: 0 },
      { texto: "Bram Stoker", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um homem que se torna obcecado por um retrato que parece envelhecer no seu lugar?",
    opcoes: [
      { texto: "O Retrato de Dorian Gray", valor: 10 },
      { texto: "O Corcunda de Notre Dame", valor: 0 },
      { texto: "Drácula", valor: 0 },
      { texto: "Frankenstein", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Estrangeiro'?",
    opcoes: [
      { texto: "Albert Camus", valor: 10 },
      { texto: "Franz Kafka", valor: 0 },
      { texto: "Fyodor Dostoevsky", valor: 0 },
      { texto: "Jean-Paul Sartre", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de crianças que descobre poderes sobrenaturais?",
    opcoes: [
      { texto: "Os Garotos Corvos", valor: 0 },
      { texto: "Percy Jackson e o Ladrão de Raios", valor: 0 },
      { texto: "O Nome do Vento", valor: 0 },
      { texto: "O Circo da Noite", valor: 0 },
    ],
  },
  {
    pergunta: "Quem escreveu 'Cem Anos de Solidão'?",
    opcoes: [
      { texto: "Gabriel García Márquez", valor: 10 },
      { texto: "Isabel Allende", valor: 0 },
      { texto: "Mario Vargas Llosa", valor: 0 },
      { texto: "Julio Cortázar", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de uma mulher que se apaixona por um vampiro?",
    opcoes: [
      { texto: "Crepúsculo", valor: 0 },
      { texto: "Drácula", valor: 0 },
      { texto: "Entrevista com o Vampiro", valor: 0 },
      { texto: "Anjo Mecânico", valor: 0 },
    ],
  },
  {
    pergunta: "Quem é o autor de 'O Lobo do Mar'?",
    opcoes: [
      { texto: "Jack London", valor: 10 },
      { texto: "Herman Melville", valor: 0 },
      { texto: "Robert Louis Stevenson", valor: 0 },
      { texto: "Jules Verne", valor: 0 },
    ],
  },
  {
    pergunta:
      "Qual é o título do livro que conta a história de um grupo de jovens em busca de uma cidade secreta?",
    opcoes: [
      { texto: "A Cidade do Sol", valor: 0 },
      { texto: "A Estrada", valor: 0 },
      { texto: "A Cidade de Papel", valor: 0 },
      { texto: "A Cidade das Esmeraldas", valor: 0 },
    ],
  },
];
