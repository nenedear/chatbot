<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!--my css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<style>


html, body {
    height: 50%;
}

body {
    background: #fff;
    font-family: monospace;
}

.b-chat {
    width: 90%;
    margin: 0 5%;
    padding: 1em 0;
    height: 100%;


}   
&__container {
        max-width: 500px;
        margin: auto;
        height: 100%;

}

#chat, .c-chat {
    height: 100%;
}

.c-chat {
    width: 100%;
    position: relative;
    height: 100%;
    font-size: 1em;

    &__list {
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        overflow-x: visible;
        height: 90%;
        
        &::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
            
        .c-chat__item {
            text-align: left;
    
            &--human {
                text-align: right;

                .c-chat__message {
                    background: #00ac92;
                    color: #fff;
                    border-top-right-radius: 0;
                    border-top-left-radius: 10px;
                }
                                        ```        }
    
            margin-bottom: 1em;
        }
        
        .c-chat__message {
            display: inline-block;
            background: #fff;
            color: #222;
    
            padding: 0.6em;
            border-radius: 10px;
            border-top-left-radius: 0;
                
            animation-name: bounceIn;
            animation-duration: 0.4s;
            animation-fill-mode: both;
            
            .c-chat__item--human &{
                background: #00ac92;
                color: #fff;
                border-top-right-radius: 0;
                border-top-left-radius: 10px;
            }
            
        }
    
        .c-chat__action {
            border-bottom: 1px dotted #fff;
            color: #fff;
            padding: 0.6em;
            display: inline-block;
    
            animation-name: bounceIn;
            animation-duration: 0.4s;
            animation-fill-mode: both;
    
            margin-right: 0.8em;

            &:hover {
                border-bottom: 1px dotted transparent;
            }
        }
    }

    &__form {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        
        input {
            padding: 1em;
            width: 100%;
            border: none;
            font-family: monospace;
            border-bottom: 1px solid #fff;
            background: none;
            color: #fff;
            opacity: 0;
            transition: opacity 0.4s;

            &, &:focus {
                outline: none;
            }

        }
    }

    &--ready {
        input {
            opacity: 1;
        }
    }
}

@keyframes bounceIn{
  0%{
    opacity: 0;
    transform: scale(0.3);
  }
  50%{
    opacity: 0.9;
    transform: scale(1.1);
  }
  80%{
    opacity: 1;
    transform: scale(0.89);
  }
  100%{
    opacity: 1;
    transform: scale(1);
  }
}
</style>

<body>
    <div class="b-chat">
        <div class="b-chat__container">
                <div id="chat"></div>
        </div>
    </div>
    <script>
            console.clear();

     const messages = [
    {
        author: 'loading',
        body: '...',
        timeout: 0
    },
    {
        author: 'bot',
        body: 'Hello',
        timeout: 800
    },
    {
        author: 'bot',
        body: 'Follow the white rabbit...',
        timeout: 1500
    },
    {
        author: 'bot',
        body: 'Ach i\'m kidding, it\'s me, Paul',
        timeout: 3000
    },
    {
        author: 'bot',
        body: 'What\'s up?',
        timeout: 4000
    },
    {
        author: 'bot',
        body: [
            {
                url: '/blog/',
                text: 'Blog'
            },
            {
                url: 'https://codepen.io/onefastsnail',
                text: 'Codepen'
            },
            {
                url: 'https://github.com/onefastsnail',
                text: 'Github'
            }
        ],
        timeout: 5000
    }
];

const responses = [
    'This bot silly',
    'No really, its a gimic, quickly made in my Codepen',
    [
        'Ok here is a joke...',
        'When Alexander Graham Bell invented the telephone he had three missed calls from Chuck Norris'
    ],
    [
        'Want another? Ok last one...',
        'Chuck Norris can win a game of Connect 4 with 3 moves'
    ],
    'I\'m out, good bye.'
];

const Message = props => {
    const { id, author, body } = props.data;

    let finalBody;

    if (Array.isArray(body)) {
        finalBody = body.map((item, index) => {
            return <a href={item.url} className="c-chat__action" key={index}>{item.text}</a>;
        });
    }
    else {
        finalBody = <div className="c-chat__message">{body}</div>;
    }

    return (
        <li className={"c-chat__item c-chat__item--" + author}>
            {finalBody}
        </li>
    );
};

class Chat extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            messages: [],
            responses: 0
        };

        this.handleSubmit = this.handleSubmit.bind(this);
        this.demo = this.demo.bind(this);
        this.mockReply = this.mockReply.bind(this);
    }

    componentDidMount() {
        this.demo();
    }

    demo() {

        this.setState({
            messages: [],
            responses: 0
        });

        messages.map((item, index) => {
            setTimeout(() => this.addMessage(item), item.timeout);
        });
        
        // window.addEventListener('keydown', (e) => {
        //     // if d for demo
        //     if (e.keyCode == "68") {
        //         this.demo();
        //     }
        // });
        
        setTimeout(() => {
            this.setState({
                messages: this.state.messages.slice(1, this.state.messages.length)
            });
        }, 700);

    }

    addMessage(item) {
        this.setState({
            messages: [...this.state.messages, item]
        });

        setTimeout(() => {
            const items = document.querySelectorAll('li');
            const lastItem = items[items.length - 1];
            document.querySelector('.c-chat__list').scrollTop = lastItem.offsetTop + lastItem.style.height;
        }, 100);
    }

    handleSubmit(e) {
        e.preventDefault();
        
        this.addMessage({
            author: 'human',
            body: e.target.querySelector('input').value
        });

        this.mockReply();

        e.target.reset();

    }

    mockReply() {
        let response;

        if (this.state.responses == 0) {
            response = responses[this.state.responses];
        }
        else {
            if(responses[this.state.responses]) response = responses[this.state.responses];
        }

        if(response){
            this.setState({
                responses: this.state.responses + 1
            });

            if(Array.isArray(response)){
                response.map((item, index) => {
                    setTimeout(() => this.addMessage({ author: 'bot', body: item }), 600 + (500 * index));
                });
            }
            else {
                setTimeout(() => this.addMessage({ author: 'bot', body: response }), 600);
            }
        }
    }

    render() {

        let cssClass = ['c-chat'];

        if(this.state.messages.length > 4){
            cssClass.push('c-chat--ready');
        }

        if(this.state.messages.length == 5){
            document.querySelector('input').focus();
        }

        return (
            <div className={cssClass.join(' ')}>
                <ul className="c-chat__list">
                    {this.state.messages.map((message, index) => <Message key={index} data={message} />)}
                </ul>
                <form className="c-chat__form" onSubmit={this.handleSubmit}>
                    <input type="text" name="input" placeholder="Type your message here..." autoFocus autoComplete="off" required />
                </form>
            </div>
        );
    }
}

ReactDOM.render(<Chat />, document.getElementById('chat'));
            </script>

    <!--Bootstrap Js-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> 
</body>
</html>