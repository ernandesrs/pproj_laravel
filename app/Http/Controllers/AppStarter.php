<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Slug;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppStarter extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $this->mkMasterAdmin();
        $this->mkPages();

        return "<br>* started *<br>";
    }

    /**
     * @return void
     */
    private function mkMasterAdmin()
    {
        $adm = new User();

        if (User::where("email", "admin@admin.com")->count()) {
            echo "master admin exists<br>";
        } else {
            $adm->first_name = "Master";
            $adm->last_name = "Admin";
            $adm->name = $adm->first_name . " " . $adm->last_name;
            $adm->username = $adm->first_name;
            $adm->level = 9;
            $adm->gender = User::GENDER_MALE;
            $adm->email = "admin@admin.com";
            $adm->password = Hash::make("admin");
            $adm->email_verified_at  = date("Y-m-d H:i:s");

            $adm->save();

            echo "master admin created<br>";
        }
    }

    /**
     * @return void
     */
    private function mkPages()
    {
        $user = Auth::user();

        /**
         * home page create
         */

        if (Slug::where(config("app.locale"), "inicio")->count())
            echo "home page exists<br>";
        else {
            $homePageSlug = new Slug();
            $homePageSlug->set("inicio", config("app.locale"));
            $homePageSlug->save();

            $homePage = new Page();
            $homePage->title = "Um título para a página inicial";
            $homePage->description = "Uma descrição muito boa para a página inicial do site, é com isso que o Google e outras ferramentas irão encontrar seu site.";
            $homePage->content_type = Page::CONTENT_TYPE_VIEW;
            $homePage->content = $homePage->getContent(["content_type" => Page::CONTENT_TYPE_VIEW, "view_path" => "front.index"]);
            $homePage->protection = Page::PROTECTION_SYSTEM;
            $homePage->status = Page::STATUS_PUBLISHED;
            $homePage->author_id = $user->id;
            $homePage->slug_id = $homePageSlug->id;
            $homePage->save();
        }

        /**
         * privacy terms page create
         */

        if (Slug::where(config("app.locale"), "politicas-de-privacidade")->count())
            echo "privacy terms page exists<br>";
        else {
            $privacyPageSlug = new Slug();
            $privacyPageSlug->set("politicas-de-privacidade", config("app.locale"));
            $privacyPageSlug->save();

            $privacyPage = new Page();
            $privacyPage->title = "Políticas de privacidade";
            $privacyPage->description = "Uma descrição legal para esta página de políticas de privacidade";
            $privacyPage->content_type = Page::CONTENT_TYPE_TEXT;
            $privacyPage->content = $privacyPage->getContent(["content_type" => Page::CONTENT_TYPE_TEXT, "content" => "<h2>Política Privacidade</h2> <p>A sua privacidade é importante para nós. É política do " . config("app.name") . " respeitar a sua privacidade em relação a qualquer informação sua que possamos coletar no site <a href='" . route("front.index") . "'>" . config("app.name") . "</a>, e outros sites que possuímos e operamos.</p> <p>Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Também informamos por que estamos coletando e como será usado. </p> <p>Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Quando armazenamos dados, protegemos dentro de meios comercialmente aceitáveis ​​para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.</p> <p>Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto quando exigido por lei.</p> <p>O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente de que não temos controle sobre o conteúdo e práticas desses sites e não podemos aceitar responsabilidade por suas respectivas políticas de privacidade. </p> <p>Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços desejados.</p> <p>O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contato conosco.</p> <h2>Política de Cookies " . config("app.name") . "</h2> <h3>O que são cookies?</h3> <p>Como é prática comum em quase todos os sites profissionais, este site usa cookies, que são pequenos arquivos baixados no seu computador, para melhorar sua experiência. Esta página descreve quais informações eles coletam, como as usamos e por que às vezes precisamos armazenar esses cookies. Também compartilharemos como você pode impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o downgrade ou 'quebrar' certos elementos da funcionalidade do site.</p> <h3>Como usamos os cookies?</h3> <p>Utilizamos cookies por vários motivos, detalhados abaixo. Infelizmente, na maioria dos casos, não existem opções padrão do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles adicionam a este site. É recomendável que você deixe todos os cookies se não tiver certeza se precisa ou não deles, caso sejam usados ​​para fornecer um serviço que você usa.</p> <h3>Desativar cookies</h3> <p>Você pode impedir a configuração de cookies ajustando as configurações do seu navegador (consulte a Ajuda do navegador para saber como fazer isso). Esteja ciente de que a desativação de cookies afetará a funcionalidade deste e de muitos outros sites que você visita. A desativação de cookies geralmente resultará na desativação de determinadas funcionalidades e recursos deste site. Portanto, é recomendável que você não desative os cookies.</p> <h3>Cookies que definimos</h3> <ul> <li> Cookies relacionados à conta<br><br> Se você criar uma conta conosco, usaremos cookies para o gerenciamento do processo de inscrição e administração geral. Esses cookies geralmente serão excluídos quando você sair do sistema, porém, em alguns casos, eles poderão permanecer posteriormente para lembrar as preferências do seu site ao sair.<br><br> </li> <li> Cookies relacionados ao login<br><br> Utilizamos cookies quando você está logado, para que possamos lembrar dessa ação. Isso evita que você precise fazer login sempre que visitar uma nova página. Esses cookies são normalmente removidos ou limpos quando você efetua logout para garantir que você possa acessar apenas a recursos e áreas restritas ao efetuar login.<br><br> </li> <li> Cookies relacionados a boletins por e-mail<br><br> Este site oferece serviços de assinatura de boletim informativo ou e-mail e os cookies podem ser usados ​​para lembrar se você já está registrado e se deve mostrar determinadas notificações válidas apenas para usuários inscritos / não inscritos.<br><br> </li> <li> Pedidos processando cookies relacionados<br><br> Este site oferece facilidades de comércio eletrônico ou pagamento e alguns cookies são essenciais para garantir que seu pedido seja lembrado entre as páginas, para que possamos processá-lo adequadamente.<br><br> </li> <li> Cookies relacionados a pesquisas<br><br> Periodicamente, oferecemos pesquisas e questionários para fornecer informações interessantes, ferramentas úteis ou para entender nossa base de usuários com mais precisão. Essas pesquisas podem usar cookies para lembrar quem já participou numa pesquisa ou para fornecer resultados precisos após a alteração das páginas.<br><br> </li> <li> Cookies relacionados a formulários<br><br> Quando você envia dados por meio de um formulário como os encontrados nas páginas de contacto ou nos formulários de comentários, os cookies podem ser configurados para lembrar os detalhes do usuário para correspondência futura.<br><br> </li> <li> Cookies de preferências do site<br><br> Para proporcionar uma ótima experiência neste site, fornecemos a funcionalidade para definir suas preferências de como esse site é executado quando você o usa. Para lembrar suas preferências, precisamos definir cookies para que essas informações possam ser chamadas sempre que você interagir com uma página for afetada por suas preferências.<br> </li> </ul> <h3>Cookies de Terceiros</h3> <p>Em alguns casos especiais, também usamos cookies fornecidos por terceiros confiáveis. A seção a seguir detalha quais cookies de terceiros você pode encontrar através deste site.</p> <ul> <li> Este site usa o Google Analytics, que é uma das soluções de análise mais difundidas e confiáveis ​​da Web, para nos ajudar a entender como você usa o site e como podemos melhorar sua experiência. Esses cookies podem rastrear itens como quanto tempo você gasta no site e as páginas visitadas, para que possamos continuar produzindo conteúdo atraente. </li> </ul> <p>Para mais informações sobre cookies do Google Analytics, consulte a página oficial do Google Analytics.</p> <ul> <li> As análises de terceiros são usadas para rastrear e medir o uso deste site, para que possamos continuar produzindo conteúdo atrativo. Esses cookies podem rastrear itens como o tempo que você passa no site ou as páginas visitadas, o que nos ajuda a entender como podemos melhorar o site para você.</li> <li> Periodicamente, testamos novos recursos e fazemos alterações subtis na maneira como o site se apresenta. Quando ainda estamos testando novos recursos, esses cookies podem ser usados ​​para garantir que você receba uma experiência consistente enquanto estiver no site, enquanto entendemos quais otimizações os nossos usuários mais apreciam.</li> <li> À medida que vendemos produtos, é importante entendermos as estatísticas sobre quantos visitantes de nosso site realmente compram e, portanto, esse é o tipo de dados que esses cookies rastrearão. Isso é importante para você, pois significa que podemos fazer previsões de negócios com precisão que nos permitem analizar nossos custos de publicidade e produtos para garantir o melhor preço possível.</li> </ul> <h3>Compromisso do Usuário</h3> <p>O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o " . config("app.name") . " oferece no site e com caráter enunciativo, mas não limitativo:</p> <ul> <li>A) Não se envolver em atividades que sejam ilegais ou contrárias à boa fé a à ordem pública;</li> <li>B) Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, ou casas de apostas, jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;</li> <li>C) Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do " . config("app.name") . ", de seus fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.</li> </ul> <h3>Mais informações</h3> <p>Esperemos que esteja esclarecido e, como mencionado anteriormente, se houver algo que você não tem certeza se precisa ou não, geralmente é mais seguro deixar os cookies ativados, caso interaja com um dos recursos que você usa em nosso site.</p>"]);
            $privacyPage->protection = Page::PROTECTION_SYSTEM;
            $privacyPage->status = Page::STATUS_PUBLISHED;
            $privacyPage->author_id = $user->id;
            $privacyPage->slug_id = $privacyPageSlug->id;
            $privacyPage->save();
        }

        /**
         * use terms page create
         */
        if (Slug::where(config("app.locale"), "termos-de-uso")->count())
            echo "use terms page exists<br>";
        else {
            $useTermsSlug = new Slug();
            $useTermsSlug->set("termos-de-uso", config("app.locale"));
            $useTermsSlug->save();

            $useTerms = new Page();
            $useTerms->title = "Termos de uso";
            $useTerms->description = "Uma descrição legal para esta página de termos de uso";
            $useTerms->content_type = Page::CONTENT_TYPE_TEXT;
            $useTerms->content = $useTerms->getContent(["content_type" => Page::CONTENT_TYPE_TEXT, "content" => "<h2>1. Termos</h2> <p>Ao acessar ao site <a href='" . route("front.index") . "'>" . config("app.name") . "</a>, concorda em cumprir estes termos de serviço, todas as leis e regulamentos aplicáveis ​​e concorda que é responsável pelo cumprimento de todas as leis locais aplicáveis. Se você não concordar com algum desses termos, está proibido de usar ou acessar este site. Os materiais contidos neste site são protegidos pelas leis de direitos autorais e marcas comerciais aplicáveis.</p> <h2>2. Uso de Licença</h2> <p>É concedida permissão para baixar temporariamente uma cópia dos materiais (informações ou software) no site " . config("app.name") . " , apenas para visualização transitória pessoal e não comercial. Esta é a concessão de uma licença, não uma transferência de título e, sob esta licença, você não pode: </p> <ol> <li>modificar ou copiar os materiais; </li> <li>usar os materiais para qualquer finalidade comercial ou para exibição pública (comercial ou não comercial); </li> <li>tentar descompilar ou fazer engenharia reversa de qualquer software contido no site " . config("app.name") . "; </li> <li>remover quaisquer direitos autorais ou outras notações de propriedade dos materiais; ou </li> <li>transferir os materiais para outra pessoa ou 'espelhe' os materiais em qualquer outro servidor.</li> </ol> <p>Esta licença será automaticamente rescindida se você violar alguma dessas restrições e poderá ser rescindida por " . config("app.name") . " a qualquer momento. Ao encerrar a visualização desses materiais ou após o término desta licença, você deve apagar todos os materiais baixados em sua posse, seja em formato eletrónico ou impresso.</p> <h2>3. Isenção de responsabilidade</h2> <ol> <li>Os materiais no site da " . config("app.name") . " são fornecidos 'como estão'. " . config("app.name") . " não oferece garantias, expressas ou implícitas, e, por este meio, isenta e nega todas as outras garantias, incluindo, sem limitação, garantias implícitas ou condições de comercialização, adequação a um fim específico ou não violação de propriedade intelectual ou outra violação de direitos. </li> <li>Além disso, o " . config("app.name") . " não garante ou faz qualquer representação relativa à precisão, aos resultados prováveis ​​ou à confiabilidade do uso dos materiais em seu site ou de outra forma relacionado a esses materiais ou em sites vinculados a este site.</li> </ol> <h2>4. Limitações</h2> <p>Em nenhum caso o " . config("app.name") . " ou seus fornecedores serão responsáveis ​​por quaisquer danos (incluindo, sem limitação, danos por perda de dados ou lucro ou devido a interrupção dos negócios) decorrentes do uso ou da incapacidade de usar os materiais em " . config("app.name") . ", mesmo que " . config("app.name") . " ou um representante autorizado da " . config("app.name") . " tenha sido notificado oralmente ou por escrito da possibilidade de tais danos. Como algumas jurisdições não permitem limitações em garantias implícitas, ou limitações de responsabilidade por danos conseqüentes ou incidentais, essas limitações podem não se aplicar a você.</p> <h2>5. Precisão dos materiais</h2> <p>Os materiais exibidos no site da " . config("app.name") . " podem incluir erros técnicos, tipográficos ou fotográficos. " . config("app.name") . " não garante que qualquer material em seu site seja preciso, completo ou atual. " . config("app.name") . " pode fazer alterações nos materiais contidos em seu site a qualquer momento, sem aviso prévio. No entanto, " . config("app.name") . " não se compromete a atualizar os materiais.</p> <h2>6. Links</h2> <p>O " . config("app.name") . " não analisou todos os sites vinculados ao seu site e não é responsável pelo conteúdo de nenhum site vinculado. A inclusão de qualquer link não implica endosso por " . config("app.name") . " do site. O uso de qualquer site vinculado é por conta e risco do usuário.</p> </p> <h3>Modificações</h3> <p>O " . config("app.name") . " pode revisar estes termos de serviço do site a qualquer momento, sem aviso prévio. Ao usar este site, você concorda em ficar vinculado à versão atual desses termos de serviço.</p> <h3>Lei aplicável</h3> <p>Estes termos e condições são regidos e interpretados de acordo com as leis do " . config("app.name") . " e você se submete irrevogavelmente à jurisdição exclusiva dos tribunais naquele estado ou localidade.</p>"]);
            $useTerms->protection = Page::PROTECTION_SYSTEM;
            $useTerms->status = Page::STATUS_PUBLISHED;
            $useTerms->author_id = $user->id;
            $useTerms->slug_id = $useTermsSlug->id;
            $useTerms->save();
        }

        /**
         * comment terms page create
         */

        if (Slug::where(config("app.locale"), "politica-de-comentarios")->count())
            echo "comment terms page exists<br>";
        else {
            $commentTermsSlug = new Slug();
            $commentTermsSlug->set("politica-de-comentarios", config("app.locale"));
            $commentTermsSlug->save();

            $commentTerms = new Page();
            $commentTerms->title = "Política de comentários";
            $commentTerms->description = "Uma descrição legal para esta página de política de comentários";
            $commentTerms->content_type = Page::CONTENT_TYPE_TEXT;
            $commentTerms->content = $commentTerms->getContent(["content_type" => Page::CONTENT_TYPE_TEXT, "content" => '<h2><strong>Política de comentários</strong></h2>
        <p>Apreciamos discussões e diferentes pontos de vista, mas o mais 
        importante é que valorizamos a discussões respeitosas e construtivas
        com outros os autores e leitores. </p>
        <p>Temos tolerância zero para 
        comentários que acreditamos que possam ser considerados inapropriados ou
         ofensivos, que exibam comportamento semelhante a trolls e que não seja relacionado ao conteúdo abordado na página.</p>
        <p>Os comentaristas podem 
        sinalizar comentários potencialmente inadequados para revisão, por 
        preocupação com outras pessoas ou devido a ofensa pessoal. </p>
        <p>Você pode sinalizar um comentário por meio do menu ao lado de um comentário potencialmente 
        ofensivo ou nos enviar um e-mail por meio de nossa página de contato. </p>
        <h2><strong>Como comentar: </strong></h2>
        <p>Nossos comentários são registrados e moderados plataforma de terceiros(<a href="https://disqus.com/" target="_blank">Disqus</a>), que exige que os usuários configurem uma conta. </p>
        <p>Você pode registrar um perfil Disqus diretamente no Disqus ou pode facilmente realizar um cadastro rápido com suas contas do Facebook, Twitter ou Google. </p>
        <p>Ao contrário das primeiras políticas do Facebook e do Google, o Disqus não exige que você use seu nome real. </p>
        <p>No entanto, preferimos que os 
        comentaristas usem seu nome real porque eles são mais propensos a se 
        comportar de forma mais madura, em vez de se soltarem enquanto se 
        escondem atrás de um pseudônimo.</p><h2><strong>Vamos manter um relacionamento saudável:</strong></h2>
        <p>Discussões e debates são 
        bem-vindos, mas comentários que não tenha nada haver com o conteúdo da página, que contenha palavras de baixo calão, ofensas ao autor ou outros leitores não serão toleráveis. </p>
        <p>Embora reconhecendo que 
        haverá, às vezes, pontos de vista diferentes, nos reservamos o direito 
        de advertir os comentaristas abertamente, excluir, editar ou modificar 
        um tópico que viole nossas diretrizes e suspender ou banir infratores 
        reincidentes. </p>
        <p>Além disso, não toleraremos 
        racismo, sexismo, homofobia ou outras formas de discurso de ódio ou 
        contribuições que possam ser interpretadas como tal. </p>
        <h2><strong>Clareza e intenção: </strong></h2>
        <p>O tom da palavra escrita nem sempre é óbvio, então pare e pense duas vezes antes de publicar seu comentário. </p>
        <p>"Gritos" – letras, palavras ou
         frases em maiúsculas – e o uso de emojis, outros símbolos e linguagem 
        imprópria são desaprovados porque são projetados para fazer um 
        comentário se destacar dos outros. </p>
        <p>O uso dessas e de técnicas 
        semelhantes pode levar à exclusão, edição ou modificação do comentário a
         critério da moderação.  Os infratores reincidentes 
        podem enfrentar uma suspensão parcial ou um banimento permanente. </p>
        <h2><strong>Imagens do usuário (avatares): </strong></h2>
        <p>Imagens de mau gosto nos perfis de foto/imagem de usuário do Disqus (também conhecido como avatar) serão banidas. </p>
        <p>Exemplos de conteúdo proibido 
        incluem imagens sexualmente explícitas, sugestivas ou reveladoras;  
        representações de violência ou sangue;  imagens brutas;  a celebração ou
         representação de criminosos ou atividade criminosa;  propaganda. </p>
        <h2><strong>Perfis alternativos: </strong></h2>
        <p>Os comentaristas são 
        solicitados a manter apenas um perfil, e nossos moderadores sinalizam os
         endereços IP dos infratores reincidentes. </p>
        <p>Infratores reincidentes com várias contas serão banidos da nossa seção de comentários. </p>
        <h2><strong>Links: </strong></h2>
        <p>Os links para todos os sites foram desativados para proteger nosso site e visitantes contra spam e malware. </p>
        <p>Links para <em>páginas internas ao nosso site </em>são
         permitidos, no entanto, comentários que incluam esses links serão 
        inicialmente retidos, aguardando uma revisão antes de serem publicados. </p>
        <h2><strong>Quem realiza as moderações? </strong></h2>
        <p>O monitoramento e a moderação da discussão na seção de comentários do <em>nosso site </em>são feitos pelos autores e outros administradores do site. Os leitores podem contribuir sinalizando um comentário que viole nosas regras. </p>
        <p><em>Estas diretrizes podem ser revisadas ou atualizadas a qualquer momento, sem aviso prévio. </em></p>']);
            $commentTerms->protection = Page::PROTECTION_SYSTEM;
            $commentTerms->status = Page::STATUS_PUBLISHED;
            $commentTerms->author_id = $user->id;
            $commentTerms->slug_id = $commentTermsSlug->id;
            $commentTerms->save();
        }
    }
}
