import tkinter as tk
from tkinter import messagebox, ttk
import sqlite3

# Conexão ao banco de dados SQLite
conn = sqlite3.connect('industriadb.sqlite')
cursor = conn.cursor()


# Função para criar tabelas no banco de dados
def criar_tabelas():
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Pecas (
        numero INTEGER PRIMARY KEY,                         
        peso REAL,                                         
        cor TEXT                                         
    )''')

    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Depositos (
        numero INTEGER PRIMARY KEY,                       
        endereco TEXT                                     
    )''')

    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Fornecedores (
        numero INTEGER PRIMARY KEY,                        
        endereco TEXT                                     
    )''')

    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Projetos (
        numero INTEGER PRIMARY KEY,                         
        orcamento REAL                                    
    )''')

    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Funcionarios (
        numero INTEGER PRIMARY KEY,                        
        salario REAL,                                     
        telefone TEXT,                                    
        departamento_id INTEGER,                         
        FOREIGN KEY (departamento_id) REFERENCES Departamentos(numero)
    )''')

    cursor.execute('''
    CREATE TABLE IF NOT EXISTS Departamentos (
        numero INTEGER PRIMARY KEY,                        
        setor TEXT                                       
    )''')

    conn.commit()


# Função para adicionar uma peça
def adicionar_peca():
    numero = entry_numero_peca.get()
    peso = entry_peso.get()
    cor = entry_cor.get()
    if numero and peso and cor:
        cursor.execute("INSERT INTO Pecas (numero, peso, cor) VALUES (?, ?, ?)", (numero, peso, cor))
        conn.commit()
        messagebox.showinfo("Sucesso", "Peça adicionada com sucesso!")
        entry_numero_peca.delete(0, tk.END)
        entry_peso.delete(0, tk.END)
        entry_cor.delete(0, tk.END)
    else:
        messagebox.showwarning("Entrada inválida", "Preencha todos os campos.")


# Função para visualizar peças
def visualizar_pecas():
    cursor.execute("SELECT * FROM Pecas")
    rows = cursor.fetchall()
    for row in rows:
        tree.insert("", tk.END, values=row)


# Criar a interface do usuário
def criar_interface():
    global entry_numero_peca, entry_peso, entry_cor, tree

    window = tk.Tk()
    window.title("Gerenciamento de Indústria")

    # Formulário para adicionar peças
    frame = tk.Frame(window)
    frame.pack(pady=10)

    tk.Label(frame, text="Número:").grid(row=0, column=0)
    entry_numero_peca = tk.Entry(frame)
    entry_numero_peca.grid(row=0, column=1)

    tk.Label(frame, text="Peso:").grid(row=1, column=0)
    entry_peso = tk.Entry(frame)
    entry_peso.grid(row=1, column=1)

    tk.Label(frame, text="Cor:").grid(row=2, column=0)
    entry_cor = tk.Entry(frame)
    entry_cor.grid(row=2, column=1)

    tk.Button(frame, text="Adicionar Peça", command=adicionar_peca).grid(row=3, columnspan=2, pady=10)

    # Árvore para visualizar peças
    tree = ttk.Treeview(window, columns=("Número", "Peso", "Cor"), show='headings')
    tree.heading("Número", text="Número")
    tree.heading("Peso", text="Peso")
    tree.heading("Cor", text="Cor")
    tree.pack(pady=20)

    tk.Button(window, text="Visualizar Peças", command=visualizar_pecas).pack(pady=5)

    window.mainloop()


# Executar o aplicativo
criar_tabelas()
criar_interface()

# Fechar a conexão ao banco de dados ao finalizar
conn.close()
