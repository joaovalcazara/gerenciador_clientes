<!-- src/components/CadastroUsuario.svelte -->
<script>
    import { navigate } from 'svelte-routing';
    import AuthController from '../controllers/AuthController';
    
    let usuario = { username: '', password: '' };
  
    async function cadastrarUsuario() {
      const resposta = await AuthController.cadastrarUsuario(usuario);
      if (resposta.success) {
        navigate('/login');
      } else {
        console.error('Falha no cadastro de usuário');
      }
    }
  </script>
  
  <main>
    <h1>Cadastro de Usuário</h1>
    
    <label>Usuário: <input bind:value={usuario.username} /></label>
    <label>Senha: <input type="password" bind:value={usuario.password} /></label>
    
    <button on:click={cadastrarUsuario}>Cadastrar</button>
  </main>
  
  <style>
    /* Estilos aqui */
  </style>
  