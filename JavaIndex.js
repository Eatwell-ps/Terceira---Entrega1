document.addEventListener('DOMContentLoaded', function() {
  // Objetivos e sugestões de refeições
  const mealSuggestions = {
    "Perder peso": {
      breakfast: "Iogurte natural com chia, maçã e chá verde (≈300 kcal)",
      lunch: "Peito de frango grelhado, arroz integral, legumes cozidos (≈500 kcal)",
      dinner: "Sopa de legumes leve ou omelete com espinafre (≈350 kcal)"
    },
    "Ganhar massa muscular": {
      breakfast: "Ovos mexidos, aveia com banana e pasta de amendoim (≈600 kcal)",
      lunch: "Arroz, feijão, bife, batata-doce, salada (≈800 kcal)",
      dinner: "Panqueca de aveia com frango desfiado (≈600 kcal)"
    },
    "Melhorar alimentação": {
      breakfast: "Vitamina de frutas, pão integral com queijo branco (≈400 kcal)",
      lunch: "Quinoa, frango grelhado, salada colorida (≈550 kcal)",
      dinner: "Sanduíche natural com alface, tomate e atum (≈450 kcal)"
    }
  };

  // Dicas nutricionais
  const nutritionTips = [
    "Beber água regularmente ajuda na digestão e na saúde da pele",
    "Consuma pelo menos 3 porções de frutas por dia",
    "Prefira alimentos integrais aos refinados",
    "Inclua proteínas em todas as refeições principais",
    "Reduza o consumo de alimentos ultraprocessados",
    "Mastigue bem os alimentos para melhor digestão"
  ];

  // Carrega as preferências do usuário
  function loadUserPreferences() {
    const userGoals = JSON.parse(localStorage.getItem('userGoals')) || ['Melhorar alimentação'];
    const userName = localStorage.getItem('userName') || 'Usuário';
    
    updateMealSuggestions(userGoals);
    document.getElementById('user-greeting').textContent = `Olá, ${userName}!`;
  }

  // Atualiza as sugestões de refeições
  function updateMealSuggestions(goals) {
    const breakfastEl = document.getElementById('breakfast-suggestion');
    const lunchEl = document.getElementById('lunch-suggestion');
    const dinnerEl = document.getElementById('dinner-suggestion');
    
    // Limpa sugestões anteriores
    breakfastEl.textContent = '';
    lunchEl.textContent = '';
    dinnerEl.textContent = '';
    
    // Adiciona sugestões para cada objetivo
    goals.forEach(goal => {
      if (mealSuggestions[goal]) {
        const breakfastItem = document.createElement('div');
        breakfastItem.textContent = mealSuggestions[goal].breakfast;
        breakfastEl.appendChild(breakfastItem);
        
        const lunchItem = document.createElement('div');
        lunchItem.textContent = mealSuggestions[goal].lunch;
        lunchEl.appendChild(lunchItem);
        
        const dinnerItem = document.createElement('div');
        dinnerItem.textContent = mealSuggestions[goal].dinner;
        dinnerEl.appendChild(dinnerItem);
      }
    });
    
    // Se nenhum objetivo, mostra mensagem padrão
    if (goals.length === 0) {
      breakfastEl.textContent = "Nenhuma sugestão disponível. Defina seus objetivos nas configurações.";
    }
  }

  // Mostra uma dica nutricional aleatória
  function showRandomTip() {
    const randomIndex = Math.floor(Math.random() * nutritionTips.length);
    document.getElementById('nutrition-tip').textContent = nutritionTips[randomIndex];
  }

  // Configura os checkboxes
  function setupCheckboxes() {
    document.querySelectorAll('.checkbox-container input').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const card = this.closest('.task-card');
        if (this.checked) {
          card.classList.add('completed');
        } else {
          card.classList.remove('completed');
        }
        
        // Atualiza no localStorage
        saveTaskStatus();
      });
    });
  }

  // Salva o status das tarefas
  function saveTaskStatus() {
    const tasks = {
      breakfast: document.getElementById('breakfast-check').checked,
      lunch: document.getElementById('lunch-check').checked,
      dinner: document.getElementById('dinner-check').checked
    };
    
    localStorage.setItem('dailyTasks', JSON.stringify(tasks));
  }

  // Carrega o status das tarefas
  function loadTaskStatus() {
    const savedTasks = JSON.parse(localStorage.getItem('dailyTasks'));
    if (savedTasks) {
      document.getElementById('breakfast-check').checked = savedTasks.breakfast;
      document.getElementById('lunch-check').checked = savedTasks.lunch;
      document.getElementById('dinner-check').checked = savedTasks.dinner;
      
      // Aplica classes de completed
      if (savedTasks.breakfast) {
        document.getElementById('breakfast-check').closest('.task-card').classList.add('completed');
      }
      if (savedTasks.lunch) {
        document.getElementById('lunch-check').closest('.task-card').classList.add('completed');
      }
      if (savedTasks.dinner) {
        document.getElementById('dinner-check').closest('.task-card').classList.add('completed');
      }
    }
  }

  // Configura notificações
  function setupNotifications() {
    if (!('Notification' in window)) {
      console.log('Este navegador não suporta notificações desktop');
      return;
    }
    
    if (Notification.permission === 'granted') {
      scheduleNotifications();
    } else if (Notification.permission !== 'denied') {
      Notification.requestPermission().then(permission => {
        if (permission === 'granted') {
          scheduleNotifications();
        }
      });
    }
  }

  // Agenda notificações
  function scheduleNotifications() {
    // Notificação matinal (8h)
    const morningTime = new Date();
    morningTime.setHours(8, 0, 0, 0);
    if (new Date() > morningTime) {
      morningTime.setDate(morningTime.getDate() + 1);
    }
    
    setTimeout(() => {
      showNotification("Hora do café da manhã! 🍳", "Comece seu dia com uma refeição nutritiva");
      // Repete a cada 24 horas
      setInterval(() => {
        showNotification("Hora do café da manhã! 🍳", "Comece seu dia com uma refeição nutritiva");
      }, 24 * 60 * 60 * 1000);
    }, morningTime - new Date());

    // Configura notificações similares para almoço e jantar
    // ...
  }

  // Mostra notificação
  function showNotification(title, body) {
    new Notification(title, {
      body: body,
      icon: '/images/notification-icon.png'
    });
  }

  // Inicialização
  loadUserPreferences();
  showRandomTip();
  setupCheckboxes();
  loadTaskStatus();
  setupNotifications();
  
  // Atualiza dica a cada hora
  setInterval(showRandomTip, 60 * 60 * 1000);

// Gerenciamento de receitas
const recipes = {
  "low-carb": [
    {
      title: "Omelete de Espinafre",
      time: "15 min",
      calories: "320 kcal",
      ingredients: ["3 ovos", "1 xícara de espinafre", "1 colher de azeite"],
      image: "omelete.jpg"
    }
    // Mais receitas...
  ],
  // Outras categorias...
};

function loadRecipes(filter = 'all') {
  const container = document.getElementById('recipes-container');
  container.innerHTML = '';
  
  const recipesToShow = filter === 'all' 
    ? Object.values(recipes).flat() 
    : recipes[filter] || [];
  
  recipesToShow.forEach(recipe => {
    const card = document.createElement('div');
    card.className = 'recipe-card';
    card.innerHTML = `
      <div class="recipe-image" style="background-image: url(${recipe.image})"></div>
      <div class="recipe-info">
        <h4 class="recipe-title">${recipe.title}</h4>
        <div class="recipe-meta">
          <span><i class="far fa-clock"></i> ${recipe.time}</span>
          <span><i class="fas fa-fire"></i> ${recipe.calories}</span>
        </div>
      </div>
    `;
    container.appendChild(card);
  });
}

// Calculadora de calorias
document.getElementById('calorie-form').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const gender = formData.get('gender');
  const age = parseInt(formData.get('age'));
  const weight = parseFloat(formData.get('weight'));
  const height = parseInt(formData.get('height'));
  const activity = parseFloat(formData.get('activity'));
  
  // Fórmula Harris-Benedict
  let bmr;
  if (gender === 'male') {
    bmr = 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age);
  } else {
    bmr = 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age);
  }
  
  const tdee = Math.round(bmr * activity);
  document.getElementById('calorie-result').innerHTML = `
    <p>Sua necessidade diária estimada é de <strong>${tdee} calorias</strong></p>
    <p>Para perder peso: ${tdee - 500} calorias/dia</p>
    <p>Para ganhar peso: ${tdee + 500} calorias/dia</p>
  `;
});

// Gerenciamento de lista de compras
document.getElementById('add-item').addEventListener('click', function() {
  const input = document.getElementById('new-item');
  if (input.value.trim()) {
    const li = document.createElement('li');
    li.className = 'list-item';
    li.innerHTML = `
      <label class="checkbox-container">
        <input type="checkbox">
        <span class="checkmark"></span>
        ${input.value}
      </label>
      <button class="btn-icon small"><i class="fas fa-trash-alt"></i></button>
    `;
    document.getElementById('shopping-items').appendChild(li);
    input.value = '';
  }
});

document.querySelector('.nutrition-btn').addEventListener('click', function() {
  const sexo = document.querySelector('.nutrition-select:first-of-type').value;
  const idade = document.querySelector('.nutrition-input[placeholder="anos"]').value;
  const peso = document.querySelector('.nutrition-input[placeholder="kg"]').value;
  const altura = document.querySelector('.nutrition-input[placeholder="cm"]').value;
  const atividade = document.querySelector('.nutrition-select:last-of-type').value;
  
  if (!idade || !peso || !altura) {
    alert("Preencha todos os campos corretamente");
    return;
  }
  
  // Simulação de cálculo
  document.querySelector('.nutrition-tip p').innerHTML = 
    `<em>Necessidade diária: ~2000 kcal (baseado nos dados)</em>`;
});

// Banco de dados de alimentos (pode ser substituído por uma API real)
const foodDatabase = [
  {
    name: "Peito de Frango Grelhado",
    diets: ["low-carb", "keto", "high-protein"],
    calories: 165,
    protein: 31,
    carbs: 0,
    fats: 3.6,
    image: "https://example.com/frango.jpg"
  },
  {
    name: "Quinoa Cozida",
    diets: ["vegetariana", "vegana", "sem-gluten", "high-protein"],
    calories: 120,
    protein: 4.4,
    carbs: 21.3,
    fats: 1.9,
    image: "https://example.com/quinoa.jpg"
  },
  // Adicione mais alimentos...
];

// Função de busca
function searchFood() {
  const searchTerm = document.getElementById('food-search-input').value.toLowerCase();
  const dietType = document.getElementById('diet-type-select').value;
  
  const resultsContainer = document.getElementById('food-results');
  
  // Filtra os alimentos
  let results = foodDatabase.filter(food => {
    const matchesSearch = food.name.toLowerCase().includes(searchTerm);
    const matchesDiet = dietType === "" || food.diets.includes(dietType);
    return matchesSearch && matchesDiet;
  });
  
  // Exibe os resultados
  if (results.length === 0) {
    resultsContainer.innerHTML = `
      <div class="empty-state">
        <i class="fas fa-search"></i>
        <p>Nenhum alimento encontrado. Tente outros termos.</p>
      </div>
    `;
    return;
  }
  
  let html = '';
  results.forEach(food => {
    html += `
      <div class="food-card">
        <img src="${food.image || 'https://via.placeholder.com/100'}" alt="${food.name}" class="food-image">
        <div class="food-info">
          <h3 class="food-name">${food.name}</h3>
          <div>
            ${food.diets.map(diet => `<span class="food-diet">${formatDietName(diet)}</span>`).join('')}
          </div>
          <div class="food-nutrition">
            <strong>${food.calories}kcal</strong> | 
            Proteína: ${food.protein}g | 
            Carboidratos: ${food.carbs}g | 
            Gorduras: ${food.fats}g
          </div>
        </div>
      </div>
    `;
  });
  
  resultsContainer.innerHTML = html;
}

// Formata os nomes das dietas
function formatDietName(diet) {
  const names = {
    "low-carb": "Low Carb",
    "keto": "Keto",
    "vegetariana": "Vegetariana",
    "vegana": "Vegana",
    "sem-gluten": "Sem Glúten",
    "high-protein": "Alta Proteína",
    "diabeticos": "Para Diabéticos"
  };
  return names[diet] || diet;
}

// Event listeners
document.getElementById('search-food-btn').addEventListener('click', searchFood);

// Buscar ao pressionar Enter
document.getElementById('food-search-input').addEventListener('keypress', function(e) {
  if (e.key === 'Enter') {
    searchFood();
  }
});

// Adicione esta função para redirecionar para a página de notificações
document.querySelector('.btn-icon[aria-label="Notificações"]').addEventListener('click', function(e) {
  // Se já estiver na página de notificações, não faz nada
  if (!window.location.pathname.includes('notificacoes.html')) {
    window.location.href = 'notificacoes.html';
  }
});

// Atualize a função de notificações para persistir as notificações
function enviarNotificacao() {
  const mensagem = mensagens[Math.floor(Math.random() * mensagens.length)];
  
  // Salva a notificação no localStorage
  const notifications = JSON.parse(localStorage.getItem('notifications') || []);
  notifications.unshift({
    message: mensagem,
    timestamp: new Date().toISOString(),
    read: false
  });
  localStorage.setItem('notifications', JSON.stringify(notifications));
  
  // Atualiza o badge
  updateNotificationBadge();
  
  // Mostra a notificação
  if (Notification.permission === "granted") {
    new Notification("Lembrete de Saúde", {
      body: mensagem,
      icon: "https://cdn-icons-png.flaticon.com/512/728/728093.png"
    });
  }
}

// Função para atualizar o contador de notificações
function updateNotificationBadge() {
  const notifications = JSON.parse(localStorage.getItem('notifications') || []);
  const unreadCount = notifications.filter(n => !n.read).length;
  const badge = document.querySelector('.badge');
  
  if (badge) {
    badge.textContent = unreadCount;
    badge.style.display = unreadCount > 0 ? 'flex' : 'none';
  }
}

// Chamar ao carregar a página
window.addEventListener('DOMContentLoaded', updateNotificationBadge);

});